<template>
    <div v-if="show" :class="getClass">
      <button @click="hideAlert">&times;</button>
      <p>{{ message }}</p>
    </div>
  </template>

  <script>
  import { ref } from 'vue';

  export default {
    props: {
      type: {
        type: String,
        default: 'info',
        validator: (value) => ['info', 'success', 'warning', 'error'].includes(value)
      },
      message: {
        type: String,
        required: true
      }
    },
    setup(props) {
      const show = ref(true);

      const getClass = () => {
        return `alert alert-${props.type}`;
      };

      const hideAlert = () => {
        show.value = false;
      };

      return {
        show,
        getClass,
        hideAlert
      };
    }
  };
  </script>

  <style scoped>
  .alert {
    padding: 10px;
    margin-bottom: 10px;
  }

  .alert-info {
    background-color: #e2e8f0;
    color: #2d3748;
  }

  .alert-success {
    background-color: #c6f6d5;
    color: #047857;
  }

  .alert-warning {
    background-color: #faf089;
    color: #9a6b04;
  }

  .alert-error {
    background-color: #feb2b2;
    color: #c53030;
  }
  </style>
