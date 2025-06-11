<div class="{{ $parentClass }}">
    <label for="{{ $id }}" class="form-label mt-3">{{ $label }}</label>
      <input id="{{ $id }}" type="{{ $type }}" class="form-control" 
            name="{{ (isset($name)) ? $name:""; }}"
            value="{{ (isset($value))?$value:"";  }}"
            placeholder="{{ (isset($placeholder))?$placeholder:""; }}"
            {{ ($required)?"required":""}} {{ ($readOnly=="true")?"readyOnly":"" }} {{ ($disabled=="true")?"disabled":"" }}>
</div>

