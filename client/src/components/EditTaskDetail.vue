<script setup>
const props = defineProps({
  initialData: {
    type: Object,
    required: true
  }
})

const { nombre, correo } = toRefs(props.initialData)

const onSubmit = () => {
  // Aquí se enviaría el formulario a un servidor o API
  // Ejemplo:
  axios.post('/api/usuarios', {
    nombre: nombre.value,
    correo: correo.value
  })
  .then(() => {
    // Se muestra un mensaje de éxito
    emit('success')
  })
  .catch((error) => {
    // Se muestra un mensaje de error
    console.log(error)
  })
}
</script>


<template>
    <form @submit.prevent="onSubmit">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" v-model="nombre" class="form-control">
      </div>
      <div class="form-group">
        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" v-model="correo" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
  </template>
  