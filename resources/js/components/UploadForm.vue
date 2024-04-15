<template>
    <div>
      <input type="file" @change="handleFileChange">
      <button @click="uploadFile" :disabled="!selectedFile">Загрузить файл</button>
      <p v-if="uploading">Загрузка файла...</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        selectedFile: null,
        uploading: false
      };
    },
    methods: {
      handleFileChange(event) {
        this.selectedFile = event.target.files[0];
      },
      uploadFile() {
        if (!this.selectedFile) {
          return;
        }
        this.uploading = true;
        let formData = new FormData();
        formData.append('file', this.selectedFile);
        axios.get('/api/upload', formData)
          .then(response => {
            console.log(response.data);
            this.$emit('upload-success', response.data); // Эмитируем событие upload-success и передаем результаты загрузки
            this.uploading = false;
            this.selectedFile = null;
          })
          .catch(error => {
            console.error(error);
            this.uploading = false;
          });
      }
    }
  };
  </script>