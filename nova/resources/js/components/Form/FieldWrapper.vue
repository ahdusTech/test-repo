<template functional>
  <div class="flex border-40" :class="{ 'flex-col': props.stacked }">
    <slot />
  </div>
</template>
<script>
export default {
  props: {
    stacked: { type: Boolean, default: false },
  },
}
</script>
