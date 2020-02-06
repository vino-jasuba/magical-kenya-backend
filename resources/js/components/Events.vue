<style scoped>
.action-link {
  cursor: pointer;
}
</style>

<template>
  <div class="col">
    <div class="table-responsive">
      <table class="table align-items-center table-flush">
        <thead class="thead-light">
          <tr>
            <th scope="col">Title</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">URL</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data" :key="item.id">
            <td>{{item.title}}</td>
            <td>{{(new Date(item.start_date)).toDateString()}}</td>
            <td>{{((new Date(item.end_date))).toDateString()}}</td>
            <td>
              <a :href="item.external_url">Link</a>
            </td>
            <td class="text-right">
              <div class="dropdown">
                <a
                  class="btn btn-sm btn-icon-only text-light"
                  href="#"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  <span class="dropdown-item" @click="edit(item.id)">Edit</span>
                  <!-- show edit modal -->
                  <span class="dropdown-item" @click="remove(item.id)">Delete</span>
                  <!-- make delete request -->
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ["events"],
  data() {
    return {
      data: [],
      isLoading: true
    };
  },

  mounted() {
    this.isLoading = false;
    this.data = JSON.parse(this.events).data;
  },

  methods: {
    edit(item) {
      window.location.href = "/events/" + item;
    },

    remove(item) {
      axios
        .delete("/events/" + item)
        .then(res => {
            window.location.href = "/events"
        })
        .catch(err => {});
    }
  }
};
</script>
