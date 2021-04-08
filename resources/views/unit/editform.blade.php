
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="code" class="form-control" style="text-transform:uppercase" value="{{$unit->code}}" required readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="name" class="form-control" placeholder="Nama Unit" value="{{$unit->name}}" style="text-transform:uppercase" autofocus required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <select name="type" class="form-control" required>
                <option value="{{$unit->type}}">{{$unit->type}}</option>
                <option value="Length">Length</option>
                <option value="Size Spec">Size Spec</option>
                <option value="Weight">Weight</option>
                <option value="Amount">Amount</option>
                <option value="Dimension">Dimension</option>
                <option value="Volume">Volume</option>
                <option value="Packaging">Packaging</option>
                <option value="Custom">Custom</option>
              </select>
            </div>
          </div>