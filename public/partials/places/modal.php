<?php

function myfossil_places_modal( $place=null )
{
?>

    <!-- Modal -->
    <div class="modal fade" id="placesModal" tabindex="-1" role="dialog" aria-labelledby="placesModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="placesModalLabel">Create New Place</h4>
          </div>
          <div class="modal-body">
      <form id="new-place-form" role="form">
           <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" placeholder="Name">
        </div>
           <div class="form-group">
          <label for="description">Description</label>
          <input type="text" class="form-control" id="description" placeholder="Description">
        </div>
        <label for="type">Type</label>
        <select class="form-control" id="type">
          <option value="City Park">City Park</option>
          <option value="State Park">State Park</option>
          <option value="National Park">National Park</option>
          <option value="Collecting Site">Collecting Site</option>
          <option value="Museum">Museum</option>
          <option value="Event Venue">Event Venue</option>
          <option value="Other">Other</option>
           </select>

        <div class="form-group">
          <label for="country">Country</label>
          <input type="text" class="form-control" id="country" placeholder="Country">
        </div>
           <div class="form-group">
          <label for="State">State</label>
          <input type="text" class="form-control" id="state" placeholder="State">
        </div>
           <div class="form-group">
          <label for="county">County</label>
          <input type="text" class="form-control" id="county" placeholder="County">
        </div>
           <div class="form-group">
          <label for="city">City</label>
          <input type="text" class="form-control" id="city" placeholder="City">
        </div>
           <div class="form-group">
          <label for="zip">Zip</label>
          <input type="text" class="form-control" id="zip" placeholder="Zip">
        </div>
           <div class="form-group">
          <label for="address">Street Address</label>
          <input type="text" class="form-control" id="address" placeholder="Street Address">
        </div>
           <div class="form-group">
          <label for="latitude">Latitude</label>
          <input type="text" class="form-control" id="latitude" placeholder="Latitude">
        </div>
           <div class="form-group">
          <label for="longitude">Longitude</label>
          <input type="text" class="form-control" id="longitude" placeholder="Longitude">
        </div>
          <div class="form-group">
          <label for="url">URL</label>
          <input type="text" class="form-control" id="url" placeholder="URL">
        </div>

        <div class="form-group">
          <label for="map_url">Map URL</label>
          <input type="text" class="form-control" id="map_url" placeholder="Map URL">
        </div>
       </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" id="add-place-form-submit" class="btn btn-primary">Add place</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php
}
