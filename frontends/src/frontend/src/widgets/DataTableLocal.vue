<template>
	<b-row>
		<!-- input search -->
		<b-col sm="6">
			<div class="custom-search d-flex justify-content-start">
				<b-form-group>
					<div class="d-flex align-items-center">
						<btn-add v-if="newAble" @clickMe="$emit('clickNew')" />
					</div>
				</b-form-group>
			</div>
		</b-col>
		<b-col sm="6">
			<div class="custom-search d-flex justify-content-end">
				<b-form-group>
					<div class="d-flex align-items-center">
						<label class="mr-1">Search</label>
						<b-form-input
							v-model="searchTerm"
							placeholder="Search"
							type="text"
							class="d-inline-block"
						/>
					</div>
				</b-form-group>
			</div>
		</b-col>

		<!-- table -->
		<b-col sm="12">
			<vue-good-table
				:columns="_customColumn"
				:rows="_items"
				:rtl="direction"
				:line-numbers="lineNumbers"
				:search-options="{
					enabled: true,
					externalQuery: searchTerm,
				}"
				:pagination-options="{
					enabled: true,
					perPage: pageLength,
				}"
			>
				<template slot="table-row" slot-scope="props">
					<!-- Column: Action -->
					<span
						v-if="props.column.field === 'action'"
						class="demo-inline"
						style="width:1444px"
					>
						<b-button
							v-if="viewAble"
							variant="outline-primary"
							class="btn-icon btn-sm mr-1"
							title="View"
							@click="$emit('clickView', props.row)"
						>
							<feather-icon icon="SearchIcon" />
						</b-button>

						<b-button
							v-if="editAble"
							variant="outline-warning"
							class="btn-icon btn-sm mr-1"
							title="Edit"
							@click="$emit('clickEdit', props.row)"
						>
							<feather-icon icon="Edit2Icon" />
						</b-button>

						<b-button
							v-if="deleteAble"
							variant="outline-danger"
							class="btn-icon btn-sm mr-1"
							title="Delete"
							@click="clickDelete(props.row)"
						>
							<feather-icon icon="Trash2Icon" />
						</b-button>
					</span>

					<!-- Column: Common -->
					<span v-else>
						{{ props.formattedRow[props.column.field] }}
					</span>
				</template>

				<!-- pagination -->
				<template slot="pagination-bottom" slot-scope="props">
					<div class="d-flex justify-content-between flex-wrap">
						<div class="d-flex align-items-center mb-0 mt-1">
							<span class="text-nowrap">
								แสดง 1 ถึง
							</span>
							<b-form-select
								v-model="pageLength"
								:options="['3', '5', '10', '50', '100']"
								class="mx-1"
								@input="
									(value) => props.perPageChanged({ currentPerPage: value })
								"
							/>
							<span class="text-nowrap "> of {{ props.total }} entries </span>
						</div>
						<div>
							<b-pagination
								:value="1"
								:total-rows="props.total"
								:per-page="pageLength"
								first-number
								last-number
								align="right"
								prev-class="prev-item"
								next-class="next-item"
								class="mt-1 mb-0"
								@input="(value) => props.pageChanged({ currentPage: value })"
							>
								<template #prev-text>
									<feather-icon icon="ChevronLeftIcon" size="18" />
								</template>
								<template #next-text>
									<feather-icon icon="ChevronRightIcon" size="18" />
								</template>
							</b-pagination>
						</div>
					</div>
				</template>
			</vue-good-table>
		</b-col>
	</b-row>
</template>

<script>
import {
	BAvatar,
	BBadge,
	BPagination,
	BFormGroup,
	BFormInput,
	BFormSelect,
	BDropdown,
	BDropdownItem,
} from 'bootstrap-vue'
import { VueGoodTable } from 'vue-good-table'
import store from '@/store/index'

export default {
	props: {
		url: '',
		items: null,
		/**
		 * ต้องการเปิด ให้ค้นหาบ่นหัวช่องหรือไม่
		 * @default false
		 */
		searchAll: {
			type: Boolean,
			default: false,
		},
		lineNumbers: {
			type: Boolean,
			default: true,
		},
		columns: {
			type: Array,
			default: [
				{
					label: 'Name',
					field: 'fullName',
					filterOptions: {
						enabled: true,
						placeholder: 'Search Name',
					},
				},
			],
		},

		viewAble: {
			type: Boolean,
			default: true,
		},
		editAble: {
			type: Boolean,
			default: true,
		},
		deleteAble: {
			type: Boolean,
			default: true,
		},
		newAble: {
			type: Boolean,
			default: true,
		},
		setPageLength: {
			type: Number,
			default: 10,
		},
		ableActionDelete: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			dir: false,
			rows: [],
			searchTerm: '',
			pageLength: this.setPageLength,
			fetchItems: '',
		}
	},
	components: {
		VueGoodTable,
		BAvatar,
		BBadge,
		BPagination,
		BFormGroup,
		BFormInput,
		BFormSelect,
		BDropdown,
		BDropdownItem,
	},

	computed: {
		_items() {
			if (this.items) {
				return this.items
			}
			return this.fetchItems
		},
		_customColumn() {
			let columns = this.convert.cp(this.columns)
			const viewAble = this.viewAble
			const editAble = this.editAble
			const deleteAble = this.deleteAble
			const searchAll = this.searchAll

			if (viewAble || editAble || deleteAble) {
				columns.push({
					label: '',
					field: 'action',
				})
			}

			if (searchAll) {
				columns = columns.map((item) => {
					let _item = item
					if (item.field != 'action') {
						if (item.filterOptions) {
							_item.filterOptions['enabled'] = true
							_item.filterOptions['placeholder'] = _item.label
						} else {
							_item['filterOptions'] = {
								enabled: true,
								placeholder: 'Search Name',
							}
						}
					}
					return _item
				})
			}

			return columns
		},
		statusVariant() {
			const statusColor = {
				/* eslint-disable key-spacing */
				Current: 'light-primary',
				Professional: 'light-success',
				Rejected: 'light-danger',
				Resigned: 'light-warning',
				Applied: 'light-info',
				/* eslint-enable key-spacing */
			}

			return (status) => statusColor[status]
		},
		direction() {
			if (store.state.appConfig.isRTL) {
				// eslint-disable-next-line vue/no-side-effects-in-computed-properties
				this.dir = true
				return this.dir
			}
			// eslint-disable-next-line vue/no-side-effects-in-computed-properties
			this.dir = false
			return this.dir
		},
	},
	created() {
		this.queryItmes()
	},
	methods: {
		async queryItmes() {
			try {
				if (!this.url) return ''
				this.fetchItems = await this.api.get(this.url)
				return ''
			} catch (error) {
				console.error(error)
				return ''
			}
		},
		clickDelete(data) {
			if (this.ableActionDelete) {
				this._clickDelete(data)
				return ''
			}
			this.$emit('clickDelete', data)
		},
		async _clickDelete(data) {
			try {
				const spUrl = this.url.replace('index', data.id)
				const resp = await this.api.del(spUrl, [], true)
				this.queryItmes()
			} catch (error) {
				console.error(error)
				return ''
			}
		},
	},
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-good-table.scss';
</style>
