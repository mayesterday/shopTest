<template>
  <section>
    <div class="form-group mt-1">
      <label for=""></label>
      <VueFileAgent
        ref="vueFileAgent"
        :theme="'min-width'"
        :multiple="true"
        :deletable="true"
        :meta="true"
        :accept="'image/*'"
        :maxFiles="14"
        :helpText="helpText"
        :errorText="{
          type: 'Invalid file type. Only images or zip Allowed',
          size: 'Files should not exceed 10MB in size',
        }"
        @select="filesSelected($event)"
        @beforedelete="onBeforeDelete($event)"
        @delete="fileDeleted($event)"
        v-model="fileRecords"
      ></VueFileAgent>
    </div>
  </section>
</template>
<script>
// doc: https://bestofvue.com/repo/safrazik-vue-file-agent-vuejs-file-upload
import Vue from 'vue'
import VueFileAgent from 'vue-file-agent'
import VueFileAgentStyles from 'vue-file-agent/dist/vue-file-agent.css'
Vue.use(VueFileAgent)
export default {
  mounted() {
    this.imageData = this.value
    this.getFilesDataInitial()
  },
  props: {
    value: null,
    helpText: {
      type: String,
      default: 'helpText',
    },
  },
  watch: {
    fileRecords: {
      handler: function (value) {
        console.log(value)
        this.$emit('input', value)
      },
      deep: true,
    },
  },
  data: function () {
    return {
      fileRecords: [],
      uploadUrl: 'http://shop.test/images/',
      uploadHeaders: { 'X-Test-Header': 'vue-file-agent' },
      fileRecordsForUpload: [], // maintain an upload queue
      imageData: [],
    }
  },
  methods: {
    async getFilesDataInitial() {
      try {
        var filesData = []
        const x = this.imageData
        let imgs = this.imageData
        if (!imgs) return ''

        console.log(imgs)
        imgs.forEach(function (fd) {
          fd.url = fd.filename
          fd.type = 'image/jpeg' //filesBaseUrl + fd.name
          filesData.push(fd)
        })
        this.fileRecords = filesData
      } catch (error) {
        console.error(error)
        return ''
      }
    },
    uploadFiles: function () {
      // Using the default uploader. You may use another uploader instead.
      this.$refs.vueFileAgent.upload(
        this.uploadUrl,
        this.uploadHeaders,
        this.fileRecordsForUpload
      )
      this.fileRecordsForUpload = []
    },
    deleteUploadedFile: function (fileRecord) {
      // Using the default uploader. You may use another uploader instead.
      this.$refs.vueFileAgent.deleteUpload(
        this.uploadUrl,
        this.uploadHeaders,
        fileRecord
      )
    },
    filesSelected: function (fileRecordsNewlySelected) {
      var validFileRecords = fileRecordsNewlySelected.filter(
        (fileRecord) => !fileRecord.error
      )
      this.fileRecordsForUpload =
        this.fileRecordsForUpload.concat(validFileRecords)
    },
    onBeforeDelete: function (fileRecord) {
      var i = this.fileRecordsForUpload.indexOf(fileRecord)
      if (i !== -1) {
        // queued file, not yet uploaded. Just remove from the arrays
        this.fileRecordsForUpload.splice(i, 1)
        var k = this.fileRecords.indexOf(fileRecord)
        if (k !== -1) this.fileRecords.splice(k, 1)
      } else {
        if (confirm('Are you sure you want to delete?')) {
          this.$refs.vueFileAgent.deleteFileRecord(fileRecord) // will trigger 'delete' event
        }
      }
    },
    fileDeleted: function (fileRecord) {
      var i = this.fileRecordsForUpload.indexOf(fileRecord)
      if (i !== -1) {
        this.fileRecordsForUpload.splice(i, 1)
      } else {
        this.deleteUploadedFile(fileRecord)
      }
    },
  },
}
</script>
