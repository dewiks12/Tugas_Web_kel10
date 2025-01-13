@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-clipboard-plus fs-3 text-primary me-2"></i>
                <h2 class="h3 mb-0">Create New Order</h2>
            </div>
            <a href="{{ route('employee.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('employee.orders.store') }}">
        @csrf
        
        <!-- Customer Selection -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-person-circle fs-4 text-primary me-2"></i>
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_id" class="form-label">Select Customer</label>
                            <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select a customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} - {{ $customer->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Selection -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-box-seam fs-4 text-primary me-2"></i>
                    <h5 class="card-title mb-0">Services</h5>
                </div>

                <div id="services-container">
                    <!-- Initial Service Row -->
                    <div class="service-row mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label">Service Type</label>
                                <select name="services[0][id]" class="form-select" required>
                                    <option value="">Select a service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="services[0][quantity]" class="form-control" value="1" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-danger remove-service" style="display: none;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" id="add-service" class="btn btn-outline-primary w-100">
                        <i class="bi bi-plus-circle me-2"></i>Add Another Service
                    </button>
                </div>

                @error('services')
                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Notes -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-pencil-square fs-4 text-primary me-2"></i>
                    <h5 class="card-title mb-0">Additional Notes</h5>
                </div>
                <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Add any special instructions or notes here">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('employee.dashboard') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Create Order
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('services-container');
    const addButton = document.getElementById('add-service');
    let serviceCount = 1;

    // Show/hide remove buttons based on service count
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-service');
        removeButtons.forEach(button => {
            button.style.display = container.children.length > 1 ? 'block' : 'none';
        });
    }

    // Add new service row
    addButton.addEventListener('click', function() {
        const newRow = document.querySelector('.service-row').cloneNode(true);
        
        // Update input names
        newRow.querySelectorAll('select, input').forEach(input => {
            input.name = input.name.replace('[0]', `[${serviceCount}]`);
            if (input.type === 'number') {
                input.value = '1';
            } else {
                input.value = '';
            }
        });

        // Add remove button functionality
        const removeButton = newRow.querySelector('.remove-service');
        removeButton.addEventListener('click', function() {
            newRow.remove();
            updateRemoveButtons();
        });

        container.appendChild(newRow);
        serviceCount++;
        updateRemoveButtons();
    });

    // Initialize remove buttons
    document.querySelectorAll('.remove-service').forEach(button => {
        button.addEventListener('click', function() {
            button.closest('.service-row').remove();
            updateRemoveButtons();
        });
    });
});
</script>
@endpush
@endsection 