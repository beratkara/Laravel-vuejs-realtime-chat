<template>
    <div id="app">
        <RouterView />
    </div>
</template>

<script>

export default {
  name: "app",
  page: {
    // All subcomponent titles will be injected into this template.
    titleTemplate(title) {
      title = typeof title === "function" ? title(this.$store) : title;
      return title;
    }
  }
};
</script>
