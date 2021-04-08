
          <div class="form-group">
            <div class="input-group">
              <input type="hidden" name="id" class="form-control" style="text-transform:uppercase" value="{{$tipe_bc->id}}" required readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="name" class="form-control" placeholder="Nama" value="{{$tipe_bc->name}}" style="text-transform:uppercase" autofocus required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="description" class="form-control" placeholder="Description" value="{{$tipe_bc->description}}" style="text-transform:uppercase" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <select name="jenis" class="form-control" required>
                <option value="{{$tipe_bc->jenis}}">{{$tipe_bc->jenis}}</option>
                <option value="IN">IN</option>
                <option value="OUT">OUT</option>
              </select>
            </div>
          </div>