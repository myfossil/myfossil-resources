<?php

function myfossil_events_template() {
    ?>

    <script id="tpl-events" type="text/x-handlebars-template">
    {{#each events}}
        <div class="event col-xs-12 col-sm-12 col-md-6" 
                data-event-state="{{ state }}"
                data-event-type="{{ type }}"
                data-event-date="{{ month_year }}">
            <div class="event-body">
                <h5 class="pull-left">{{ title }}</h5>
                <p class="pull-right">
                    <i class="fa fa-fw fa-clock-o"></i> 
                    {{ starts_at }} to {{ ends_at }}
                </p>
                <div class="clearfix" />
                <p>{{ content }}</p>
            </div>
        </div>
    {{/each}}
    </script>

    <?php
}
