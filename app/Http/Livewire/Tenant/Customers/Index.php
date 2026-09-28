<?php

namespace App\Http\Livewire\Tenant\Customers;

use App\Models\Customer;
use App\Services\RiskPolicyService;
use Livewire\Component;
use Livewire\WithPagination;

// 08-tenant-customers-list.html
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $risk = 'semua'; // semua | low | medium | high | blacklist

    // --- Modal "+ Tambah Customer" ---
    public bool $showTambahModal = false;

    public string $newName = '';

    public string $newPhone = '';

    public string $newAddress = '';

    protected $queryString = ['search', 'risk'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRisk(): void
    {
        $this->resetPage();
    }

    public function bukaTambahCustomer(): void
    {
        $this->reset(['newName', 'newPhone', 'newAddress']);
        $this->resetErrorBag();
        $this->showTambahModal = true;
    }

    public function tutupTambahCustomer(): void
    {
        $this->showTambahModal = false;
    }

    public function simpanCustomer()
    {
        $tenantId = auth()->user()->tenant_id;

        $data = $this->validate([
            'newName' => ['required', 'string', 'max:255'],
            'newPhone' => ['nullable', 'string', 'max:30'],
            'newAddress' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'newName' => 'nama',
            'newPhone' => 'nomor telepon',
            'newAddress' => 'alamat',
        ]);

        $customer = Customer::create([
            'tenant_id' => $tenantId,
            'name' => $data['newName'],
            'phone' => $data['newPhone'] ?: null,
            'address' => $data['newAddress'] ?: null,
        ]);

        $this->showTambahModal = false;

        // Alur produk: customer baru langsung diarahkan ke halaman verifikasi identitas
        // (09-tenant-customer-verify.html) untuk upload KTP & penilaian risiko.
        return redirect()->route('tenant.customers.verify', $customer);
    }

    public function render()
    {
        $tenantId = auth()->user()->tenant_id;

        $base = Customer::query()->where('tenant_id', $tenantId);

        $totalCustomers = (clone $base)->count();

        $lowRiskCount = (clone $base)->where('risk_score', '>=', 80)->count();
        $mediumRiskCount = (clone $base)->whereBetween('risk_score', [50, 79])->count();
        $highRiskCount = (clone $base)->where('status_verifikasi', RiskPolicyService::STATUS_PERLU_PERHATIAN)->count();
        $blacklistCount = (clone $base)->where('status_verifikasi', RiskPolicyService::STATUS_BLACKLIST)->count();

        $customers = (clone $base)
            ->withCount('bookings')
            ->search($this->search)
            ->riskFilter($this->risk === 'semua' ? null : $this->risk)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.tenant.customers.index', [
            'customers' => $customers,
            'totalCustomers' => $totalCustomers,
            'lowRiskCount' => $lowRiskCount,
            'mediumRiskCount' => $mediumRiskCount,
            'highRiskCount' => $highRiskCount,
            'blacklistCount' => $blacklistCount,
        ]);
    }
}
