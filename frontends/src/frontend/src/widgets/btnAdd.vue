<template>
	<b-button
		variant="outline-success"
		class="btn-icon "
		@click="clickMe"
		:title="text"
		:text="text"
	>
		{{ text }}
	</b-button>
</template>

<script>
export default {
	props: {
		text: {
			type: String,
			default: 'เพิ่ม',
		},
		size: {
			type: String,
			default: 'sm',
		},
		clickGotoPage: {
			type: String,
			default: '',
		},
	},
	methods: {
		clickMe() {
			const clickGotoPage = this.clickGotoPage
			if (clickGotoPage) {
				this.$router.push({ name: clickGotoPage })
				return ''
			}
			this.$emit('clickMe')
		},
	},
}
</script>
