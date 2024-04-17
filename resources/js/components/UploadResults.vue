<template>
  <div>
    <h2>Результаты загрузки</h2>
    <p>Количество правильных записей: {{ correctCount }}</p>
    <p>Количество неправильных записей: {{ incorrectCount }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      correctCount: 0,
      incorrectCount: 0
    };
  },
  created() {
    this.fetchUploadResults();
    // Обновление данных каждые 5 секунд (5000 миллисекунд)
    setInterval(this.fetchUploadResults, 500);
  },
  methods: {
    fetchUploadResults() {
  axios.get('/results')
    .then(response => {
      const data = response.data;
      this.correctCount = data.correctCount;
      this.incorrectCount = data.incorrectCount;
    })
    .catch(error => {
      console.error('Ошибка при получении результатов загрузки:', error);
    });
}
  }
};
</script>