@csrf()
<div class="card card-primary">
    <div class="card-body" style="display: block;">
        <div class="form-group">
            <label for="destiny">Destiny</label>
            <input type="text" id="destiny" name="destiny" class="form-control" value="{{ $order->destiny ?? old('destiny') }}">
        </div>
        <div class="form-group">
            <label for="going_date">Going Date</label>
            @php
            $status="";
            $id_user="";
            if(!empty($order)){
                if($order->going_date){ $datagoing=date('Y-m-d', strtotime($order->going_date));}
                if($order->back_date){ $databack=date('Y-m-d', strtotime($order->back_date));}
                if($order->status){$status=$order->status;}
                if($order->id_user){$id_user=$order->id_user;}
            }
            @endphp
            <input type="date" name="going_date" id="going_date" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask="" inputmode="numeric" value="{{ $datagoing ??  old('going_date') }}">
        </div>
        <div class="form-group">
            <label for="back_date">Deadline Date</label>
            <input type="date" name="back_date" id="back_date" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask="" inputmode="numeric" value="{{ $databack ??  old('back_date') }}">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control custom-select">
                <option selected="" disabled="">Select one</option>
                <option value="r" @if ($status == 'r' ?? old('status') == 'r') selected @endif>Requested</option>
                <option value="a" @if ($status == 'a' ?? old('status') == 'a') selected @endif>Aproved</option>
                <option value="c" @if ($status == 'c' ?? old('status') == 'c') selected @endif>Canceled</option>
            </select>
        </div>
        <div>
            <label for="id_user">User</label>
            <select id="id_user" name="id_user" class="form-control custom-select">
                <option selected="" disabled="">Select one</option>
                @foreach ($users as $user)
                    <option value="{{$user["id"]}}" @if ($id_user == '{{$user["id"]}}' ?? old('id_user') == '{{$user["id"]}}') selected @endif>{{$user["name"]}}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>