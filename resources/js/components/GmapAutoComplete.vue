<template>
  <div>
    <div class="d-flex justify-content-between">
      <gmap-autocomplete class="form-control" @place_changed="setPlace"></gmap-autocomplete>
      <button class="btn btn-grey-500 ml-4" @click="usePlace">Add</button>
    </div>
    <br />

    <GmapMap style="width: 600px; height: 300px;" :zoom="6" :center="{lat: 0, lng: 38}">
      <GmapMarker :position="position" />
    </GmapMap>
  </div>
</template>

<script>
export default {
  data() {
    return {
      position: {
        lat: null,
        lng: null
      },
      place: null
    };
  },
  methods: {
    setPlace(place) {
      this.place = place;
    },
    usePlace(place) {
      if (this.place) {
        this.position = {
          lat: this.place.geometry.location.lat(),
          lng: this.place.geometry.location.lng()
        };
        this.place = null;
      }
    }
  }
};
</script>