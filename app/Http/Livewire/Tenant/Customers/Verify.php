<?php

namespace App\Http\Livewire\Tenant\Customers;

use App\Models\Customer;
use App\Services\RiskPolicyService;
use App\Services\VerificationService;
use Livewire\Component;
use Livewire\WithFileUploads;

// 09-tenant-customer-verify.html
class Verify extends Component
{
    use WithFileUploads;

    public Customer $customer;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $ktpFile;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $selfieFile;

    public bool $consent = false;

    public function mount(Customer $customer): void
    {
        abort_unless($customer->tenant_id === auth()->user()->tenant_id, 403);

        $this->customer = $customer;
    }

    protected function rules(): array
    {
        return [
            'ktpFile' => ['required', 'image', 'max:5120'],
            'selfieFile' => ['nullable', 'image', 'max:5120'],
            'consent' => ['accepted'],
        ];
    }

    protected $messages = [
        'ktpFile.required' => 'Foto KTP wajib diunggah.',
        'ktpFile.image' => 'Foto KTP harus berupa gambar.',
        'consent.accepted' => 'Customer harus menyetujui pemrosesan data pribadi terlebih dahulu.',
    ];

    public function simpanVerifikasi(VerificationService $verificationService): void
    {
        $this->validate();

        $document = $this->customer->verificationDocuments()->create([
            'document_type' => 'ktp',
        ]);

        $document->addMedia($this->ktpFile->getRealPath())
            ->usingFileName($this->ktpFile->getClientOriginalName())
            ->toMediaCollection('ktp');

        if ($this->selfieFile) {
            $document->addMedia($this->selfieFile->getRealPath())
                ->usingFileName($this->selfieFile->getClientOriginalName())
                ->toMediaCollection('selfie');
        }

        // Consent diambil satu kali di sini untuk mewakili checkbox tunggal di wireframe
        // ("...diproses untuk keperluan verifikasi identitas dan penilaian risiko sewa").
        $this->customer->consentLogs()->create([
            'purpose' => 'Verifikasi identitas & penilaian risiko sewa',
            'consented_by' => auth()->id(),
            'consented_at' => now(),
        ]);

        $verificationService->submitDocument($document);
        $verificationService->requestRiskCheck($this->customer->fresh(), auth()->user());

        $this->customer->refresh();
        $this->reset(['ktpFile', 'selfieFile', 'consent']);

        session()->flash('success', 'Verifikasi selesai diproses.');
    }

    public function verifikasiUlang(VerificationService $verificationService): void
    {
        $verificationService->resetVerification($this->customer);

        $this->customer->refresh();
        $this->reset(['ktpFile', 'selfieFile', 'consent']);

        session()->flash('success', 'Data verifikasi sebelumnya telah dihapus. Silakan unggah dokumen baru.');
    }

    public function simpanSebagaiCustomer()
    {
        session()->flash('success', "Customer \"{$this->customer->name}\" berhasil disimpan.");

        return redirect()->route('tenant.customers.index');
    }

    public function render()
    {
        $document = $this->customer->verificationDocuments->first();
        $findings = $document?->findings ?? collect();

        $veryHub = $findings->firstWhere('ocr_provider', 'veryhub');
        $paddleOcr = $findings->firstWhere('ocr_provider', 'paddleocr');
        $reconciled = $veryHub?->reconciled_data ?? $paddleOcr?->reconciled_data;

        $status = $this->customer->status_verifikasi ?: RiskPolicyService::STATUS_BELUM;

        return view('livewire.tenant.customers.verify', [
            'document' => $document,
            'veryHub' => $veryHub,
            'paddleOcr' => $paddleOcr,
            'reconciled' => $reconciled,
            'providersAgree' => $veryHub && ! $veryHub->has_discrepancy,
            'riskFindings' => $this->customer->risk_findings ?? [],
            'statusBadge' => $this->customer->statusBadge(),
            'scoreBadge' => RiskPolicyService::scoreBadge($this->customer->risk_score, $status),
            'policy' => RiskPolicyService::policy($status),
            'consentLog' => $this->customer->consentLogs()->latest('consented_at')->first(),
            'sudahDiverifikasi' => (bool) $document,
        ]);
    }
}
