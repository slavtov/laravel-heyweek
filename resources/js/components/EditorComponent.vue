<template>
  <Editor
    :api-key="token"
    :init="myInit"
    :value="state"
  />
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

export default {
  components: {
    Editor
  },
  props: {
    state: {
      type: String,
      required: true
    },
    token: String
  },
  data() {
    return {
      myInit: {
        height: 500,
        relative_urls: false,
        remove_script_host: true,
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'image code table fullscreen | undo redo | formatselect | bold italic backcolor | \
                  alignleft aligncenter alignright alignjustify | \
                  bullist numlist outdent indent | removeformat | help',
        image_class_list: [
          { title: 'Default', value: 'img-fluid' }
        ],
        // images_upload_url: '/api/upload'
        images_upload_handler: function (blobInfo, success, failure) {
          let xhr, formData

          xhr = new XMLHttpRequest()
          xhr.withCredentials = false
          xhr.open('POST', '/api/upload')
          // xhr.setRequestHeader("X-CSRF-Token", document.head.querySelector('meta[name="csrf-token"]').content)

          xhr.onload = function() {
            let json

            if (xhr.status != 200) {
              failure('HTTP Error: ' + xhr.status)
              return
            }

            json = JSON.parse(xhr.responseText)

            if (!json || typeof json.location != 'string') {
              failure('Invalid JSON: ' + xhr.responseText)
              return
            }

            success(json.location)
          }

          formData = new FormData()
          formData.append('file', blobInfo.blob(), blobInfo.filename())

          xhr.send(formData)
        }
      }
    }
  }
}
</script>
