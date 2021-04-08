
          <div class="form-group">
            <div class="input-group">
              <input type="hidden" name="id" class="form-control" style="text-transform:uppercase" value="{{$style_sample->id}}" required readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="name" class="form-control" placeholder="Nama Unit" value="{{$style_sample->name}}" style="text-transform:uppercase" autofocus required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="tipe" class="form-control" style="text-transform:uppercase" placeholder="Tipe Style" value="{{$style_sample->tipe}}"  required>
            </div>
          </div>