@extends('home')

@section('title', 'Update Invoice')

@section('css_before')
  <link href="{{ asset('css/editinvoice.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-3">
  <div class="ship-card">
    <h2 class="ship-title">Update Invoice</h2>

    <form action="/invoice/{{ $id }}" method="post" enctype="multipart/form-data" class="ship-form">
      @csrf
      @method('put')

      {{-- Lease + Rent (เหมือนเดิม: เลือก lease แล้วตั้งค่า rent) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-file-text"></i></div>
        <div class="ship-field">
          <div class="ship-select-wrap mb-2">
            <select name="lease_id" id="lease_id" required>
              <option value="">-- Select Lease --</option>
              @foreach ($leases as $l)
                <option value="{{ $l->id }}" data-rent="{{ $l->rent_amount }}"
                  {{ old('lease_id', $lease_id) == $l->id ? 'selected' : '' }}>
                  Lease #{{ $l->id }}
                  @if ($l->room) - Room {{ $l->room->room_no }} @endif
                  @if ($l->user) - {{ $l->user->full_name }} @endif
                </option>
              @endforeach
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
          </div>
          <input type="number" step="0.01" min="0" name="amount_rent" id="amount_rent"
                 value="{{ old('amount_rent', $amount_rent) }}" placeholder="Rent" required>
          @error('lease_id') <div class="ship-error">{{ $message }}</div> @enderror
          @error('amount_rent') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Billing Period --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-calendar3"></i></div>
        <div class="ship-field">
          <input type="text" name="billing_period" value="{{ old('billing_period', $billing_period) }}"
                 placeholder="Billing Period (YYYY-MM)" required>
          @error('billing_period') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Due Date --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-calendar2-event"></i></div>
        <div class="ship-field">
          <input type="date" name="due_date" value="{{ old('due_date', $due_date) }}" required>
          @error('due_date') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Amounts (Utilities / Other / Total) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-plus-slash-minus"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input type="number" step="0.01" min="0" name="amount_utilities"
                   value="{{ old('amount_utilities', $amount_utilities) }}" placeholder="Utilities">
            @error('amount_utilities') <div class="ship-error">{{ $message }}</div> @enderror
          </div>
          <div>
            <input type="number" step="0.01" min="0" name="amount_other"
                   value="{{ old('amount_other', $amount_other) }}" placeholder="Other">
            @error('amount_other') <div class="ship-error">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-calculator"></i></div>
        <div class="ship-field">
          <input type="number" step="0.01" min="0" name="total_amount"
                 value="{{ old('total_amount', $total_amount) }}" placeholder="Total" required>
          @error('total_amount') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Status --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-ui-checks-grid"></i></div>
        <div class="ship-field">
          @php
            $statusChoices = [
              'DRAFT'   => 'ฉบับร่าง',
              'ISSUED'  => 'ออกบิล',
              'PAID'    => 'ชำระแล้ว',
              'OVERDUE' => 'ค้างชำระ',
              'CANCELED'=> 'ยกเลิก',
            ];
          @endphp
          <div class="ship-select-wrap">
            <select name="status" required>
              @foreach ($statusChoices as $value => $labelTh)
                <option value="{{ $value }}" {{ old('status', $status) === $value ? 'selected' : '' }}>
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
              'PENDING'   => 'รอดำเนินการ',
              'CONFIRMED' => 'ยืนยันแล้ว',
              'FAILED'    => 'ล้มเหลว',
            ];
          @endphp
          <div class="ship-select-wrap">
            <select name="payment_status" required>
              @foreach ($paymentChoices as $value => $labelTh)
                <option value="{{ $value }}" {{ old('payment_status', $payment_status) === $value ? 'selected' : '' }}>
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
          @if ($receipt_file_url)
            <p class="ship-note">Current file:
              <a href="{{ asset('storage/' . $receipt_file_url) }}" target="_blank">View</a>
            </p>
          @endif
          <input type="file" name="receipt_file" accept="application/pdf,image/*" class="ship-file">
          @error('receipt_file') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Actions --}}
      <div class="ship-actions">
        <a href="{{ url('/invoice') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('js_before')
  {{-- sweetalert (ถ้าใช้) --}}
  @include('sweetalert::alert')
  <script>
    (function() {
      const leaseSelect = document.getElementById('lease_id');
      const rentInput   = document.getElementById('amount_rent');

      function applyRent() {
        const opt  = leaseSelect?.options[leaseSelect.selectedIndex];
        const rent = opt?.getAttribute('data-rent');
        if (rent && !isNaN(rent)) {
          rentInput.value = Number(rent).toFixed(2);
        }
      }

      leaseSelect?.addEventListener('change', applyRent);
      document.addEventListener('DOMContentLoaded', function() {
        if (!rentInput.value) applyRent(); // preload หากมี selected อยู่แล้ว
      });
    })();
  </script>
@endsection
