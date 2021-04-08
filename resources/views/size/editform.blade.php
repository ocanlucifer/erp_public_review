
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="name" class="form-control" style="text-transform:uppercase" value="{{$size->name}}" required readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="weight" class="form-control" placeholder="Nama Unit" value="{{$size->weight}}" style="text-transform:uppercase" autofocus required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <select name="status" class="form-control" required>
                <option value="{{$size->status}}">{{$size->status}}</option>
                <option value="True">True</option>
                <option value="False">False</option>
              </select>
            </div>
          </div>