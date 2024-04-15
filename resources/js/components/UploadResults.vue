<template>
    <div>
      <h2>Результаты загрузки</h2>
      <ul>
        <li v-for="(result, index) in uploadResults" :key="index">
          {{ result.message }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        uploadResults: [] // Здесь будут храниться результаты загрузки файла
      };
    },
    created() {
      this.fetchUploadResults();
    },
    methods: {
      fetchUploadResults() {
        axios.get('/results')
          .then(response => {
            this.uploadResults = response.data.chunks;
          })
          .catch(error => {
            console.error('Ошибка при получении результатов загрузки:', error);
          });
      }
    }
  };
  </script>