<template>
    <div class="flex">
        <img
        class="h-8 w-8 rounded-full object-cover"
        :src="$page.props.auth.user.profile_photo_url"
        :alt="$page.props.auth.user.name"
      />
      <p class="ml-6 text-lg font-extrabold">{{ title }}</p>
    </div>
</template>

<script>
export default {
  props: {
    title: String,
  },
};
</script>
