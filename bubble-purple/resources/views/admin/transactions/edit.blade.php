@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">Edit Transaction</h2>
            <p class="text-muted mb-0">Invoice #{{ $transaction->invoice_number }}</p>
        </div>
        <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-secondary">
            <i class="bi bi-x-lg me-1"></i> Cancel
        </a>
    </div>

    <!-- Alert Messages -->
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Edit Form -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Customer Selection -->
                    <div class="col-md-6">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select class="form-select @error('customer_id') is-invalid @enderror" 
                                id="customer_id" 
                                name="customer_id" 
                                required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" 
                                        {{ old('customer_id', $transaction->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Branch Selection -->
                    <div class="col-md-6">
                        <label for="branch_id" class="form-label">Branch</label>
                        <select class="form-select @error('branch_id') is-invalid @enderror" 
                                id="branch_id" 
                                name="branch_id" 
                                required>
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" 
                                        {{ old('branch_id', $transaction->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Services -->
                    <div class="col-12">
                        <label class="form-label">Services</label>
                        <div id="services-container">
                            @foreach($transaction->transactionServices as $index => $transactionService)
                                <div class="row g-3 mb-3 service-row">
                                    <div class="col-md-6">
                                        <select class="form-select @error('services.' . $index . '.id') is-invalid @enderror" 
                                                name="services[{{ $index }}][id]" 
                                                required>
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" 
                                                        data-price="{{ $service->price }}"
                                                        {{ old('services.' . $index . '.id', $transactionService->service_id) == $service->id ? 'selected' : '' }}>
                                                    {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('services.' . $index . '.id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="number" 
                                                   class="form-control @error('services.' . $index . '.quantity') is-invalid @enderror" 
                                                   name="services[{{ $index }}][quantity]" 
                                                   value="{{ old('services.' . $index . '.quantity', $transactionService->quantity) }}"
                                                   min="1" 
                                                   required>
                                            <span class="input-group-text">pcs</span>
                                        </div>
                                        @error('services.' . $index . '.quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        @if($index > 0)
                                            <button type="button" class="btn btn-outline-danger remove-service">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-primary" id="add-service">
                            <i class="bi bi-plus-lg me-1"></i> Add Service
                        </button>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" 
                                  name="notes" 
                                  rows="3">{{ old('notes', $transaction->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <hr>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update Transaction
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const servicesContainer = document.getElementById('services-container');
    const addServiceBtn = document.getElementById('add-service');
    let serviceIndex = {{ count($transaction->transactionServices) }};

    addServiceBtn.addEventListener('click', function() {
        const serviceRow = document.createElement('div');
        serviceRow.className = 'row g-3 mb-3 service-row';
        serviceRow.innerHTML = `
            <div class="col-md-6">
                <select class="form-select" name="services[${serviceIndex}][id]" required>
                    <option value="">Select Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                            {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="number" class="form-control" name="services[${serviceIndex}][quantity]" value="1" min="1" required>
                    <span class="input-group-text">pcs</span>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger remove-service">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        servicesContainer.appendChild(serviceRow);
        serviceIndex++;
    });

    servicesContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-service')) {
            e.target.closest('.service-row').remove();
        }
    });
});
</script>
@endpush

@endsection 