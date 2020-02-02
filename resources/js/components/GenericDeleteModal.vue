<style>
.action-link {
  cursor: pointer;
}
</style>

<template>
  <div class="col-md-4">
    <div
      class="modal fade"
      :id="'modal-' + article.id"
      tabindex="-1"
      role="dialog"
      :aria-labelledby="'modal-' + article.id"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-danger modal-dialog-centered modal-10" role="document">
        <div class="modal-content bg-gradient-info">
          <div class="modal-header">
            <h5
              v-if="type != 'experience'"
              class="modal-title"
              id="modal-title-notification"
            >Delete {{article.title}}</h5>
            <h5 v-else class="modal-title" id="modal-title-notification">Delete {{article.name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="py-3 text-center">
              <i class="ni ni-bell-55 ni-3x"></i>
              <h4 class="heading mt-4">Are you sure you want do delete this {{type}}?</h4>
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
  props: ["type", "article"],
  methods: {
    deleteResource() {
      axios
        .delete("/events/" + this.article.id)
        .then(res => {
          window.location.href = "/events/";
        })
        .catch(err => {});
    }
  }
};
</script>
