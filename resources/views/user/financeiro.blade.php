<div class="row">
   <div class="input-field col s12">
        <form action="{{ route('financeiro.envia') }}" method="post">
            @csrf
            <input id="fii" class="form form-control" type="text" name="fii" placeholder="Qual FII você quer?">
            <div class="row">                     
                <div class="col s7">
                    <button class="btn waves-effect waves-light blue darken-4" type="submit" name="action">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>                             