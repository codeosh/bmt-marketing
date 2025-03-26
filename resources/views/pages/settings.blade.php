{{-- resources\views\pages\settings.blade.php --}}
@extends('admin.admin-dashboard')

@section('title', 'Setttings')

@section('content')
    <div class="container border shadow" style="padding: 20px;">
        <h1>Reset Data</h1>
        <p>Select the data you want to reset. This will delete all records in the selected categories.</p>

        <form action="{{ route('settings.reset') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="form-check">
                <input type="checkbox" name="reset[]" value="accounts" id="accounts" class="form-check-input">
                <label for="accounts" class="form-check-label">Accounts (All Users, Keep 1 Admin)</label>
            </div>

            <div class="form-check">
                <input type="checkbox" name="reset[]" value="bulletin" id="bulletin" class="form-check-input">
                <label for="bulletin" class="form-check-label">Bulletin</label>
            </div>

            <div class="form-check">
                <input type="checkbox" name="reset[]" value="post_template" id="post_template" class="form-check-input">
                <label for="post_template" class="form-check-label">Post Template</label>
            </div>

            <div class="form-check">
                <input type="checkbox" name="reset[]" value="reply_template" id="reply_template" class="form-check-input">
                <label for="reply_template" class="form-check-label">Reply Template</label>
            </div>

            <div class="form-check">
                <input type="checkbox" name="reset[]" value="pricelist" id="pricelist" class="form-check-input">
                <label for="pricelist" class="form-check-label">Price List</label>
            </div>

            <div class="form-check">
                <input type="checkbox" name="reset[]" value="quotation" id="quotation" class="form-check-input">
                <label for="quotation" class="form-check-label">Quotation (Customers & Items)</label>
            </div>

            <div class="form-check">
                <input type="checkbox" name="reset[]" value="insights" id="insights" class="form-check-input">
                <label for="insights" class="form-check-label">Insights</label>
            </div>

            <div class="form-check">
                <input type="checkbox" name="reset[]" value="rankings" id="rankings" class="form-check-input">
                <label for="rankings" class="form-check-label">Rankings</label>
            </div>

            <button type="submit" class="btn btn-danger mt-3"
                onclick="return confirm('Are you sure you want to reset the selected data? This cannot be undone.')">
                Reset Selected Data
            </button>
        </form>
    </div>
@endsection
