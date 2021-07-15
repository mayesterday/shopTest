<template>
	<b-card :title="title" :col="col">
		<slot></slot>
	</b-card>
</template>

<script>
import BCardCode from '@core/components/b-card-code'

export default {
	props: {
		title: String,
		col: {
			type: Number,
			default: 12,
		},
	},
	components: {
		BCardCode,
	},
}
</script>
