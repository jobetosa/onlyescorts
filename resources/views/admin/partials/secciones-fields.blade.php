<!-- Title -->
<div class="form-group template-group">
    <label for="meta_title_{{ $prefix }}" class="text-white">Título de la sección</label>
    <input type="text"
        class="form-control"
        id="meta_title2_{{ $prefix }}"
        name="meta_title2"
        placeholder="Ingrese el título meta"
        required>
</div>

<!--  Description -->
<div class="form-group template-group">
    <label for="meta_description_{{ $prefix }}" class="text-white">Descripción de la sección</label>
    <textarea class="form-control custom-textarea tinyenlace"
        id="meta_description2_{{ $prefix }}"
        name="meta_description2"
        rows="3"
        placeholder="Ingrese la descripción meta"
        required></textarea>
</div>


<div class="form-group text-right">
    <button type="submit" class="btn custom-button">Guardar Cambios</button>
    <a href="{{ route('home') }}" class="btn custom-button">Cancelar</a>
</div>