<?php

function myfossil_places_template() {
    ?>
    <script id="tpl-places" type="text/x-handlebars-template">
    {{#each places}}
        <div class="place col-xs-12 col-sm-12 col-md-6"
                data-place-state="{{ state }}"
                data-place-type="{{ type }}">
            <div class="place-body">
                <h5>{{ name }}</h5>
                <p>{{ description }}</p>
                <table class="table">
                    <tr>
                        <th>key</th>
                        <th>value</th>
                    </tr>
                    {{#if type}}
                    <tr>
                        <td>type</td>
                        <td>{{ type }}</td>
                    </tr>
                    {{/if}}
                    {{#if country}}
                    <tr>
                        <td>country</td>
                        <td>{{ country }}</td>
                    </tr>
                    {{/if}}
                    {{#if state}}
                    <tr>
                        <td>state</td>
                        <td>{{ state }}</td>
                    </tr>
                    {{/if}}
                    {{#if city}}
                    <tr>
                        <td>city</td>
                        <td>{{ city }}</td>
                    </tr>
                    {{/if}}
                    {{#if zip}}
                    <tr>
                        <td>zip</td>
                        <td>{{ zip }}</td>
                    </tr>
                    {{/if}}
                    {{#if address}}
                    <tr>
                        <td>address</td>
                        <td>{{ address }}</td>
                    </tr>
                    {{/if}}
                    {{#if latitude}}
                    <tr>
                        <td>latitude</td>
                        <td>{{ latitude }}</td>
                    </tr>
                    {{/if}}
                    {{#if longitude}}
                    <tr>
                        <td>longitude</td>
                        <td>{{ longitude }}</td>
                    </tr>
                    {{/if}}
                </table>
            </div>
        </div>
    {{/each}}
    </script>

    <?php
}
