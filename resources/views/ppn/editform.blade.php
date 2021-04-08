
          <div class="form-group">
            <div class="input-group">
              <input type="hidden" name="id" class="form-control" style="text-transform:uppercase" value="{{$ppn->id}}" required readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="ppn" class="form-control" placeholder="PPN" value="{{$ppn->ppn}}" style="text-transform:uppercase" autofocus required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="number" name="rate" class="form-control" placeholder="Rate" value="{{$ppn->rate}}" step="0.001" required>
            </div>
          </div>