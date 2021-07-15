<template>
	<b-button
		variant="outline-danger"
		class="btn-icon "
		:class="`btn-${size}`"
		@click="clickme"
		:title="text"
	>
		<feather-icon icon="Trash2Icon" />
	</b-button>
</template>

<script>
export default {
	props: {
		data: null,
		text: {
			type: String,
			default: 'ลบ',
		},
		size: {
			type: String,
			default: 'sm',
		},
	},
	methods: {
		clickme() {
			this.$emit('clickMe', this.data)
		},
	},
}
</script>
