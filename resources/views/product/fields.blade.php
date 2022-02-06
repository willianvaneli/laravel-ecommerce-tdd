<div class="row">
    <div class="col-md-6">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ !empty($product) ? $product->name : old('name')}}">
        
    </div>
    <div class="col-md-6">
        <label>Price (in cents)</label>
        <input type="number" name="price" min="0" step="1" class="form-control" value="{{ !empty($product) ? $product->price : old('price')}}">
    </div>
</div>
<div class="form-group">
    <label>Description</label>
    <textarea class="form-control" name="description" rows="6" >{{ !empty($product) ? $product->description : old('description')}}</textarea>
</div>