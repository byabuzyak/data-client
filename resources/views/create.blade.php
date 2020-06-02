<form method="POST" action="/store">
    @csrf
    <table>
        <tr>
            <td>Name:</td>
            <td>
                <input id="name" name="name" type="text" class="@error('name') is-invalid @enderror">
            </td>
        </tr>
        <tr>
            <td>Page uid:</td>
            <td>
                <input id="page_uid" name="page_uid" type="text" class="@error('page_uid') is-invalid @enderror">
            </td>
        </tr>
        <tr>
            <td>Amount:</td>
            <td>
                <input id="amount" name="amount" type="number" class="@error('amount') is-invalid @enderror">
            </td>
        </tr>
        <tr>
            <td>Currency:</td>
            <td>
                <select id="currency" name="currency" class="@error('currency') is-invalid @enderror">
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="RUR">RUR</option>
                    <option value="CHF">CHF</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit">
            </td>
        </tr>
    </table>
</form>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<style>
    .is-invalid {
        border: 1px solid red;
    }
</style>
