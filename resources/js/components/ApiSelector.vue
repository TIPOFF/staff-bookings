<template>
  <select
    v-model="selectedItem"
    @change="select"
  >
    <option value="">
      All {{ this.resource }}
    </option>

    <template v-for="item in items">
      <option
        :value="keyBy ? item[keyBy] : item"
        :key="item.id"
      >
        {{ item[labelAttribute] }}
      </option>
    </template>
  </select>
</template>

<script>
import sortBy from 'lodash.sortby'

export default {
  props: {
    value: {
      type: [String, Number]
    },
    resource: {
      type: String,
      required: true
    },
    keyBy: {
      type: String
    },
    sortBy: {
      type: String
    },
    label: {
      type: String
    }
  },
  data () {
    return {
      items: [],
      selectedItem: ''
    }
  },
  created () {
    this.selectedItem = this.value

    this.fetchItems()
  },
  methods: {
    fetchItems () {
      Nova.request().get(`/api/${this.resource}`)
        .then(response => {
          this.items = response.data.data
        })
    },
    select () {
      this.$emit('input', this.selectedItem)
      this.$emit('selected', this.selectedItem)
    }
  },
  computed: {
    sortedItems () {
      return this.sortBy
        ? sortBy(this.items, item => item[this.sortBy])
        : this.items
    },
    labelAttribute () {
      return this.label ? this.label : 'title'
    }
  }
}
</script>
