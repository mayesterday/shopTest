<template>
	<b-modal :title="title" ref="modal" no-close-on-backdrop :size="size || 'xl'" @hide="hide">
		<div slot="modal-footer">
			<b-button variant="warning" @click="save" class="mr-1" v-if="textSave != 'hidden'">
				<span v-if="!loading">{{ textSave }}</span>
				<span v-else>Loading</span>
			</b-button>

			<b-button variant="warning" @click="print" class="mr-1" v-if="textPrint != ''">
				<span v-if="!loading">{{ textPrint }}</span>
				<span v-else>Loading</span>
			</b-button>

			<b-button variant="secondary" @click="cancel" class="mr-1" v-if="btnCancelAble">{{ textCancel }}</b-button>
		</div>
		<slot />
	</b-modal>
</template>

<script>
export default {
	props: {
		textSave: {
			type: String,
			default: 'บันทึก',
		},
		textPrint: {
			type: String,
			default: '',
		},
		textCancel: {
			type: String,
			default: 'ยกเลิก',
		},
		btnCancelAble: {
			type: Boolean,
			default: true,
		},
		okTitle: null,
		title: {
			type: String,
			default: '',
		},
		loading: null,
		size: null,

		// 'okTitle', 'title', 'loading', 'size'
	},
	watch: {
		loading() {
			this.setupLoad()
		},
	},
	methods: {
		request(e) {
			this.$emit('request', e)
		},
		save(e) {
			this.$emit('save', e)
		},
		cancel(e) {
			this.$emit('cancel', e)
			this.hide()
		},
		show() {
			this.$emit('show')
			this.$refs.modal.show()
		},
		hide() {
			this.$emit('close')
			this.$refs.modal.hide()
		},
		setupLoad() {
			var target = $('.modal-content')
			if (this.loading) {
				var targetBody = $(target).find('.modal-body')
				var spinnerHtml =
					'<div class="modal-loader"><span class="spinner-small"></span></div>'
				$(target).addClass('modal-loading')
				$(targetBody).prepend(spinnerHtml)
			} else {
				$(target).removeClass('modal-loading')
				$(target).find('.modal-loader').remove()
			}
		},
		print() {
			this.$emit('print')
		},
	},
}
</script>

<style></style>
