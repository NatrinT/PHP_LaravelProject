@extends('home')
@section('js_before')
    @include('sweetalert::alert')
@section('header')
@section('sidebarMenu')
@section('content')

    <h3> :: Form Update Invoice :: </h3>

    <form action="/invoice/{{ $id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        {{-- Lease --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Lease</label>
            <div class="col-sm-6">
                <select name="lease_id" id="lease_id" class="form-control" required>
                    <option value="">-- Select Lease --</option>
                    @foreach ($leases as $l)
                        <option value="{{ $l->id }}" data-rent="{{ $l->rent_amount }}"
                            {{ old('lease_id', $lease_id) == $l->id ? 'selected' : '' }}>
                            Lease #{{ $l->id }}
                            @if ($l->room)
                                - Room {{ $l->room->room_no }}
                            @endif
                            @if ($l->user)
                                - {{ $l->user->full_name }}
                            @endif
                        </option>
                    @endforeach
                </select>

                <input type="number" step="0.01" min="0" name="amount_rent" id="amount_rent" class="form-control"
                    value="{{ old('amount_rent', $amount_rent) }}" required>

                @error('lease_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Billing Period --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Billing Period (YYYY-MM)</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="billing_period"
                    value="{{ old('billing_period', $billing_period) }}" required>
                @error('billing_period')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Due Date --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Due Date</label>
            <div class="col-sm-6">
                <input type="date" class="form-control" name="due_date" value="{{ old('due_date', $due_date) }}"
                    required>
                @error('due_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Amounts --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Rent</label>
            <div class="col-sm-4">
                <input type="number" step="0.01" min="0" class="form-control" name="amount_rent"
                    value="{{ old('amount_rent', $amount_rent) }}" required>
                @error('amount_rent')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <label class="col-sm-2">Utilities</label>
            <div class="col-sm-4">
                <input type="number" step="0.01" min="0" class="form-control" name="amount_utilities"
                    value="{{ old('amount_utilities', $amount_utilities) }}">
                @error('amount_utilities')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-2">Other</label>
            <div class="col-sm-4">
                <input type="number" step="0.01" min="0" class="form-control" name="amount_other"
                    value="{{ old('amount_other', $amount_other) }}">
                @error('amount_other')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <label class="col-sm-2">Total</label>
            <div class="col-sm-4">
                <input type="number" step="0.01" min="0" class="form-control" name="total_amount"
                    value="{{ old('total_amount', $total_amount) }}" required>
                @error('total_amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Status (TH labels, keep EN values) --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">สถานะใบแจ้งหนี้</label>
            <div class="col-sm-6">
                @php
                    $statusChoices = [
                        'DRAFT' => 'ฉบับร่าง',
                        'ISSUED' => 'ออกบิล',
                        'PAID' => 'ชำระแล้ว',
                        'OVERDUE' => 'ค้างชำระ',
                        'CANCELED' => 'ยกเลิก',
                    ];
                @endphp
                <select name="status" class="form-control" required>
                    @foreach ($statusChoices as $value => $labelTh)
                        <option value="{{ $value }}" {{ old('status', $status) === $value ? 'selected' : '' }}>
                            {{ $labelTh }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Payment Status (TH labels, keep EN values) --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">สถานะการชำระเงิน</label>
            <div class="col-sm-6">
                @php
                    $paymentChoices = [
                        'PENDING' => 'รอดำเนินการ',
                        'CONFIRMED' => 'ยืนยันแล้ว',
                        'FAILED' => 'ล้มเหลว',
                    ];
                @endphp
                <select name="payment_status" class="form-control" required>
                    @foreach ($paymentChoices as $value => $labelTh)
                        <option value="{{ $value }}"
                            {{ old('payment_status', $payment_status) === $value ? 'selected' : '' }}>
                            {{ $labelTh }}
                        </option>
                    @endforeach
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
                @if ($receipt_file_url)
                    <p>Current file:
                        <a href="{{ asset('storage/' . $receipt_file_url) }}" target="_blank">View</a>
                    </p>
                @endif
                <input type="file" name="receipt_file" class="form-control" accept="application/pdf,image/*">
                @error('receipt_file')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2"></label>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/invoice" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </form>


@endsection


@section('footer')
@endsection

@section('js_before')
@endsection

<script>
    (function() {
        const leaseSelect = document.getElementById('lease_id');
        const rentInput = document.getElementById('amount_rent');

        function applyRent() {
            const opt = leaseSelect.options[leaseSelect.selectedIndex];
            const rent = opt?.getAttribute('data-rent');
            if (rent && !isNaN(rent)) rentInput.value = Number(rent).toFixed(2);
        }

        leaseSelect?.addEventListener('change', applyRent);
        document.addEventListener('DOMContentLoaded', function() {
            if (!rentInput.value) applyRent(); // preload กรณีมีค่า selected อยู่แล้ว
        });
    })();
</script>

{{-- devbanban.com --}}
