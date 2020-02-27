<style>
.action-link {
  cursor: pointer;
}
</style>

<template>
  <div class="col-md-4">
    <div
      class="modal fade"
      :id="'modal-' + id"
      tabindex="-1"
      role="dialog"
      :aria-labelledby="'modal-' + id"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-danger modal-dialog-centered modal-10" role="document">
        <div class="modal-content bg-gradient-info">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="py-3 text-center">
              <i class="ni ni-bell-55 ni-3x"></i>
              <h4 class="heading mt-4">Are you sure you want do delete this {{type}}?</h4>
              <h3 v-if="type != 'experience'">This will also delete associated {{experiences_count}} experience(s)</h3>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
            <button
              type="button"
              class="btn btn-danger text-white ml-auto"
              data-dismiss="modal"
              @click="deleteResource"
            >Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["type", "id", "experiences_count"],
  methods: {
    deleteResource() {
      const uris = {
        location: '/locations/',
        event: '/events/',
        experience: '/experiences/',
        activity: '/activities/'
      };

      axios
        .delete(uris[this.type] + this.id)
        .then(res => {
          window.location.href = uris[this.type];
        })
        .catch(err => {});
    }
  }
};
</script>
