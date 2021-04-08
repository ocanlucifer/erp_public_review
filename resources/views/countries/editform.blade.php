
          <div class="form-group">
            <div class="input-group">
              <input type="hidden" name="id" class="form-control" style="text-transform:uppercase" value="{{$countries->id}}" required readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="kode" class="form-control" placeholder="Nama Country" value="{{$countries->kode}}" style="text-transform:uppercase" autofocus required>
            </div>
            <div class="input-group">
              <input type="text" name="name" class="form-control" placeholder="Nama Country" value="{{$countries->name}}" style="text-transform:uppercase" autofocus required>
            </div>
          </div>