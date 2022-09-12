<div>
  <style>.input-group {
    position: relative;
}

.input-group .input-area {
    outline: none;
    border: 2px solid #dadce0;
    padding: 16px 13px;
    font-size: 18px;
    border-radius: 5px;
}

.input-group .input-area:valid + .label {
    top: -8px;
    padding: 0 3px;
    font-size: 14px;
    color: #8d8d8d;
}

.input-group .input-area:focus {
    border: 2px solid royalblue;
}

.input-group .label {
    color: #8d8d8d;
    position: absolute;
    top: 20px;
    left: 13px;
    background: #ffffff;
}

.input-group .input-area:focus + .label {
    top: -8px;
    padding: 0 3px;
    font-size: 14px;
    color: royalblue;
}</style>
    <div class="form-group">
      <label for="exampleInputEmail1">Full Name</label>
      <input type="text" wire:model.debounce.500ms="fullName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="input-group">
      <input type="text" class="input-area" required id="inputField"/>
      <label for="inputField" class="label">Field</label>
  </div>
</div>