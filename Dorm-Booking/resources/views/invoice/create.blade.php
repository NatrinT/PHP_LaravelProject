@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
    <h3> :: Form Add Invoice :: </h3>

    <form action="/invoice" method="post" enctype="multipart/form-data">
        @csrf

        {{-- Lease --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Lease</label>
            <div class="col-sm-6">
                <select name="lease_id" id="lease_id" class="form-control" required>
                    <option value="">-- Select Lease --</option>
                    @foreach ($leases as $lease)
                        <option value="{{ $lease->id }}" data-rent="{{ $lease->rent_amount }}"
                            {{ old('lease_id') == $lease->id ? 'selected' : '' }}>
                            Lease #{{ $lease->id }}
                        </option>
                    @endforeach
                </select>
                @error('lease_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Billing Period --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Billing Period (YYYY-MM)</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="billing_period" value="{{ old('billing_period') }}"
                    required>
                @error('billing_period')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Due Date --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Due Date</label>
            <div class="col-sm-6">
                <input type="date" class="form-control" name="due_date" value="{{ old('due_date') }}" required>
                @error('due_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Amounts --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Rent</label>
            <div class="col-sm-4">
                <input readonly type="number" class="form-control" step="0.01" min="0" name="amount_rent"
                    id="amount_rent" value="{{ old('amount_rent') }}" required>
                @error('amount_rent')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <label class="col-sm-2">Utilities</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" step="0.01" min="0" name="amount_utilities"
                    id="amount_utilities" value="{{ old('amount_utilities') }}">
                @error('amount_utilities')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-2">Other</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" step="0.01" min="0" name="amount_other"
                    id="amount_other" value="{{ old('amount_other') }}">
                @error('amount_other')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <label class="col-sm-2">Total</label>
            <div class="col-sm-4">
                <input readonly type="number" class="form-control" step="0.01" min="0" name="total_amount"
                    id="total_amount" value="{{ old('total_amount') }}" required>
                @error('total_amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Status --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Status</label>
            <div class="col-sm-6">
                <select name="status" class="form-control" required>
                    <option value="ISSUED" {{ old('status') === 'ISSUED' ? 'selected' : '' }}>ISSUED</option>
                    <option value="PAID" {{ old('status') === 'PAID' ? 'selected' : '' }}>PAID</option>
                    <option value="OVERDUE" {{ old('status') === 'OVERDUE' ? 'selected' : '' }}>OVERDUE</option>
                    <option value="CANCELED" {{ old('status') === 'CANCELED' ? 'selected' : '' }}>CANCELED</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Payment Status --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Payment Status</label>
            <div class="col-sm-6">
                <select name="payment_status" class="form-control" required>
                    <option value="PENDING" {{ old('payment_status') === 'PENDING' ? 'selected' : '' }}>PENDING</option>
                    <option value="CONFIRMED" {{ old('payment_status') === 'CONFIRMED' ? 'selected' : '' }}>CONFIRMED
                    </option>
                    <option value="FAILED" {{ old('payment_status') === 'FAILED' ? 'selected' : '' }}>FAILED</option>
                </select>
                @error('payment_status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Receipt file --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Receipt File</label>
            <div class="col-sm-6">
                <input type="file" class="form-control" name="receipt_file" accept="application/pdf,image/*">
                @error('receipt_file')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2"></label>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/invoice" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </form>
@endsection

@section('footer')
@endsection

@section('js_before')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const leaseSelect = document.getElementById('lease_id');
            const rentInput = document.getElementById('amount_rent');
            const utiInput = document.getElementById('amount_utilities');
            const otherInput = document.getElementById('amount_other');
            const totalInput = document.getElementById('total_amount');

            function recalcTotal() {
                const r = parseFloat(rentInput.value) || 0;
                const u = parseFloat(utiInput.value) || 0;
                const o = parseFloat(otherInput.value) || 0;
                totalInput.value = (r + u + o).toFixed(2);
            }

            function setRentFromLease() {
                const opt = leaseSelect?.options[leaseSelect.selectedIndex];
                const rentAttr = opt?.getAttribute('data-rent');
                const rentNum = parseFloat(rentAttr);
                if (!Number.isNaN(rentNum)) {
                    rentInput.value = rentNum.toFixed(2);
                } else {
                    rentInput.value = '';
                }
                recalcTotal();
            }

            // bind events หลัง DOM พร้อมแล้ว
            leaseSelect?.addEventListener('change', setRentFromLease);
            [rentInput, utiInput, otherInput].forEach(el => el?.addEventListener('input', recalcTotal));

            // preload ครั้งแรก
            if (leaseSelect?.value && !rentInput.value) {
                setRentFromLease();
            } else {
                recalcTotal();
            }
        });
    </script>
@endsection
