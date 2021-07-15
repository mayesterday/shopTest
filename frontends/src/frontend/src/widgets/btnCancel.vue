<template>
	<b-button
		variant="outline-warning"
		class="btn-icon "
		@click="clickMe"
		:title="text"
		text="ยกเลิก"
	>
		{{ text }}
	</b-button>
</template>

<script>
export default {
	props: {
		text: {
			type: String,
			default: 'ยกเลิก',
		},
		size: {
			type: String,
			default: 'sm',
		},
		/**
		 * ถ้ากดปุ่มแล้วต้องการให้ไปหน้าไหน
		 * ให้ส่ง router name มา
		 */
		clickGotoPage: {
			type: String,
			default: null,
		},
	},
	methods: {
		clickMe() {
			const clickGotoPage = this.clickGotoPage
			if (clickGotoPage) {
				this.$router.push({ name: clickGotoPage })
			}
			this.$emit('clickMe')
		},
	},
}
</script>
