@extends('home')

@section('title', 'Add Invoice')

@section('css_before')
  <link href="{{ asset('css/createinvoice.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Add Invoice</h2>

    <form action="/invoice" method="post" enctype="multipart/form-data" class="ship-form">
      @csrf

      {{-- Lease --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-file-text"></i></div>
        <div class="ship-field">
          <div class="ship-select-wrap">
            <select name="lease_id" id="lease_id" required>
              <option value="">-- Select Lease --</option>
              @foreach ($leases as $lease)
                <option value="{{ $lease->id }}" data-rent="{{ $lease->rent_amount }}"
                  {{ old('lease_id') == $lease->id ? 'selected' : '' }}>
                  Lease #{{ $lease->id }}
                </option>
              @endforeach
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
          </div>
          @error('lease_id') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Billing Period --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-calendar3"></i></div>
        <div class="ship-field">
          <input type="text" name="billing_period" value="{{ old('billing_period') }}"
                 placeholder="Billing Period (YYYY-MM)" required>
          @error('billing_period') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Due Date --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-calendar2-event"></i></div>
        <div class="ship-field">
          <input type="date" name="due_date" value="{{ old('due_date') }}" required>
          @error('due_date') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Amounts (Rent / Utilities) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-cash-coin"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input readonly type="number" step="0.01" min="0" name="amount_rent" id="amount_rent"
                   value="{{ old('amount_rent') }}" placeholder="Rent" required>
            @error('amount_rent') <div class="ship-error">{{ $message }}</div> @enderror
          </div>
          <div>
            <input type="number" step="0.01" min="0" name="amount_utilities" id="amount_utilities"
                   value="{{ old('amount_utilities') }}" placeholder="Utilities">
            @error('amount_utilities') <div class="ship-error">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      {{-- Amounts (Other / Total) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-plus-slash-minus"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input type="number" step="0.01" min="0" name="amount_other" id="amount_other"
                   value="{{ old('amount_other') }}" placeholder="Other">
            @error('amount_other') <div class="ship-error">{{ $message }}</div> @enderror
          </div>
          <div>
            <input readonly type="number" step="0.01" min="0" name="total_amount" id="total_amount"
                   value="{{ old('total_amount') }}" placeholder="Total" required>
            @error('total_amount') <div class="ship-error">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      {{-- Invoice Status --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-ui-checks-grid"></i></div>
        <div class="ship-field">
          @php
            $statusChoices = [
              // 'DRAFT' => 'ฉบับร่าง',
              'ISSUED' => 'ออกบิล',
              'PAID' => 'ชำระแล้ว',
              'OVERDUE' => 'ค้างชำระ',
              'CANCELED' => 'ยกเลิก',
            ];
          @endphp
          <div class="ship-select-wrap">
            <select name="status" required>
              @foreach ($statusChoices as $value => $labelTh)
                <option value="{{ $value }}" {{ old('status') === $value ? 'selected' : '' }}>
                  {{ $labelTh }}
                </option>
              @endforeach
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
          </div>
          @error('status') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Payment Status --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-credit-card-2-front"></i></div>
        <div class="ship-field">
          @php
            $paymentChoices = [
              'PENDING' => 'รอดำเนินการ',
              'CONFIRMED' => 'ยืนยันแล้ว',
              'FAILED' => 'ล้มเหลว',
            ];
          @endphp
          <div class="ship-select-wrap">
            <select name="payment_status" required>
              @foreach ($paymentChoices as $value => $labelTh)
                <option value="{{ $value }}" {{ old('payment_status') === $value ? 'selected' : '' }}>
                  {{ $labelTh }}
                </option>
              @endforeach
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
          </div>
          @error('payment_status') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Receipt file --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-file-earmark-arrow-up"></i></div>
        <div class="ship-field">
          <input type="file" name="receipt_file" accept="application/pdf,image/*" class="ship-file">
          @error('receipt_file') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Actions --}}
      <div class="ship-actions">
        <a href="{{ url('/invoice') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Add</button>
      </div>
    </form>
  </div>
</div>
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

  leaseSelect?.addEventListener('change', setRentFromLease);
  [rentInput, utiInput, otherInput].forEach(el => el?.addEventListener('input', recalcTotal));

  if (leaseSelect?.value && !rentInput.value) {
    setRentFromLease();
  } else {
    recalcTotal();
  }
});
</script>
@endsection
