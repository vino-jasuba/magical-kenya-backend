<template>
  <div>
    <div class="d-flex justify-content-between">
      <gmap-autocomplete class="form-control" @place_changed="setPlace"></gmap-autocomplete>
    </div>
    <br />

    <GmapMap style="width: 600px; height: 300px;" :zoom="zoomLevel" :center="center">
      <GmapMarker
        :position="position"
        :clickable="true"
        :draggable="true"
        @click="updateMarkerPosition"
        @dragend="updateMarkerPosition"
      />
    </GmapMap>
  </div>
</template>

<script>
export default {
  props: ["initialPosition", "shouldZoom"],
  data() {
    return {
      position: {
        lat: null,
        lng: null
      },
      place: null,
      center: {
        lat: 0,
        lng: 38
      },
      zoomLevel: 6,
    };
  },
  watch: {
    initialPosition: function(value) {
      this.position = {
        lat: parseFloat(value.lat, 10),
        lng: parseFloat(value.lng, 10)
      };
      this.center = { ...this.position };
    },
    shouldZoom: function (value) {
      if (value) {
        this.zoomLevel = 12;
      }
    }
  },
  methods: {
    updateMarkerPosition(e) {
      this.position = {
        lat: e.latLng.lat(),
        lng: e.latLng.lng()
      };

      this.emitLocationUpdatedEvent();
    },

    setPlace(place) {
      this.place = { ...place };
      this.setPosition();
      this.center = { ...this.position };
      this.zoomLevel = 12;
    },

    setPosition() {
      this.position = {
        lat: this.place.geometry.location.lat(),
        lng: this.place.geometry.location.lng()
      };

      this.emitLocationUpdatedEvent();
    },

    emitLocationUpdatedEvent() {
      this.$emit("location-changed", this.position);
    }
  }
};
</script>