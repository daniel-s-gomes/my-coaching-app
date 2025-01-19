<template>
  <div class="coaches-container">
    <div class="filters">
      <input v-model="searchQuery" placeholder="Filter by name or location ..." @input="fetchCoaches">
      <select v-model="sortDirection" @change="fetchCoaches">
        <option value="">Sort by rate</option>
        <option value="asc">Low to High</option>
        <option value="desc">High to Low</option>
      </select>
    </div>

    <div class="coaches-grid">
      <div v-for="coach in coaches" :key="coach.id" class="coach-card">
        <h3>{{ coach.name }}</h3>
        <p>Location: {{ coach.location }}</p>
        <p>Rate: €{{ coach.hourlyRate }}/hr</p>
        <p>Rating: {{ coach.rating }}/5</p>
        <div class="expertise">
          <span v-for="skill in coach.expertise" :key="skill" class="skill-tag">
            {{ skill }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'CoachesList',
  setup() {
    const coaches = ref([]);
    const searchQuery = ref('');
    const sortDirection = ref('');

    const fetchCoaches = async () => {
      try {
        let url = '/api/api.php?'
        const params = new URLSearchParams()

        if (searchQuery.value) {
          params.append('name', searchQuery.value)
          params.append('location', searchQuery.value)
        }

        if (sortDirection.value) {
          params.append('sort', 'rate')
          params.append('direction', sortDirection.value)
        }

        const response = await fetch(`${url}${params.toString()}`)
        const data = await response.json()

        if (data.status === 'success') {
          coaches.value = data.data
        }
      } catch (error) {
        console.error('Error fetching coaches:', error)
      }
    };

    // Initial fetch
    fetchCoaches();

    return {
      coaches,
      searchQuery,
      sortDirection,
      fetchCoaches
    }
  }
}
</script>

<style>
h1 {
  font-size: 3.2rem;
}

.coaches-container {
  padding: 1.25rem;
}

.filters {
  margin-bottom: 1.25rem;
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  gap: .625rem;
  justify-content: space-between;

}

.filters input,
.filters select {
  padding: .5rem;
  border: .0625rem solid #ddd;
  border-radius: .25rem;
}

.coaches-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(18.75rem, 1fr));
  gap: 1.25rem;

}

.coach-card {
  border: .0625rem solid #ddd;
  border-radius: .05rem;
  padding: .9375rem;
  background: rgb(242, 86, 33);
}

.expertise {
  display: flex;
  flex-wrap: wrap;
  gap: .3125rem;
  margin-top: .625rem;
}

.skill-tag {
  background: #4e7dac;
  padding: .25rem .5rem;
  border-radius: .25rem;
  font-size: 0.9rem;
}

/* mobile responsiveness */
@media (min-width: 400px) {

  #app {
    >div {
      width: 70vw;
    }
  }



  .filters {
    flex-direction: row;
    flex-wrap: wrap;
    width: 100%;

    >* {
      width: 100%;
    }
  }
}

/* desktop high res responsiveness */
@media (min-width: 1280px) {

#app > div {
   width: 70vw;
}


h1 {
  font-size: 5rem;
}

.filters {
  gap: 1.25rem;
  /* justify-content: space-between; */
  padding: .9375rem 0;

  >* {
    flex: 1;
    padding: 0;
    flex-wrap: wrap;
  }
}

.coaches-grid {
  display: flex;

  >div {
    flex: 1;
  }
}

}

</style>