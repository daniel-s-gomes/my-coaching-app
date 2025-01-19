<template>
  <div>
    <h1>Coaching Platform</h1>
    <CoachesList />
  </div>
</template>

<script>
import CoachesList from './components/CoachesList.vue'

export default {
  name: 'App',
  components: {
    CoachesList
  }
}
</script>