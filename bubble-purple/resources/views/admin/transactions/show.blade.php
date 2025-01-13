@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">Transaction Details</h2>
            <p class="text-muted mb-0">Invoice #{{ $transaction->invoice_number }}</p>
        </div>
        <div>
            @if($transaction->status !== 'completed' && $transaction->status !== 'cancelled')
                <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-primary me-2">
                    <i class="bi bi-pencil me-1"></i> Edit Transaction
                </a>
            @endif
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Transaction Info -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">Transaction Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Customer</h6>
                            <p class="mb-0">{{ $transaction->customer->name }}</p>
                            <p class="mb-0"><small>{{ $transaction->customer->email }}</small></p>
                            @if($transaction->customer->phone)
                                <p class="mb-0"><small>{{ $transaction->customer->phone }}</small></p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Branch</h6>
                            <p class="mb-0">{{ $transaction->branch->name }}</p>
                            <p class="mb-0"><small>{{ $transaction->branch->address }}</small></p>
                            <p class="mb-0"><small>{{ $transaction->branch->phone }}</small></p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Service</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->transactionServices as $service)
                                    <tr>
                                        <td>{{ $service->service->name }}</td>
                                        <td class="text-end">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $service->quantity }}</td>
                                        <td class="text-end">Rp {{ number_format($service->price * $service->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total Amount</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($transaction->notes)
                        <div class="mt-4">
                            <h6 class="text-muted mb-2">Notes</h6>
                            <p class="mb-0">{{ $transaction->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Updates -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0">Status Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Current Status</h6>
                        <span class="badge bg-{{ $transaction->status_color }} fs-6">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>

                    @if($transaction->status !== 'completed' && $transaction->status !== 'cancelled')
                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="status" class="form-label">Update Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $transaction->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $transaction->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Update Status
                            </button>
                        </form>
                    @endif

                    <div class="mt-4">
                        <h6 class="text-muted mb-2">Transaction Details</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <small class="text-muted">Created At</small><br>
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </li>
                            <li class="mb-2">
                                <small class="text-muted">Last Updated</small><br>
                                {{ $transaction->updated_at->format('d M Y H:i') }}
                            </li>
                        </ul>
                    </div>

                    @if($transaction->status !== 'completed' && $transaction->status !== 'cancelled')
                        <form action="{{ route('admin.transactions.destroy', $transaction) }}" 
                              method="POST" 
                              class="mt-4"
                              onsubmit="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-1"></i> Delete Transaction
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 