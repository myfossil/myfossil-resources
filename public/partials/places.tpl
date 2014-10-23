<div class="row">
    {{ #each states }}
    <div class="col-lg-12" data-place-state="{{ state_name }}">
        <div class="row">
            {{ #each types }}
            <div class="col-lg-12" data-place-type="{{ type_name }}">
                <div class="row">
                    {{ #each places }}
                    <div class="panel panel-default col-xs-12 col-sm-12 col-md-6">
                        <div class="panel-body">
                            <h5>{{ name }}<h5>
                            <p>{{ description }}</p>
                        </div>
                    </div>
                    {{ /each }}
                </div>
            </div>
            {{ /each }}    
        </div>
    </div>
    {{ /each }}
</div>
