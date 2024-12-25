
@push('js')
<script>
     Vue.component('attach-form',{
        props: ['name','id','show','realtime','place'],
    data(){
        return{
            msg:'',
            images:[],
            record:[],
            recordValue:'',
            recorder:'',
            device:'',
            items:[],
            itemsRealtime:[],
            audio:[],
            statusRecord:'',
            maxTimeRecord:10,
            recordTimeS:0,
            recordTimeM:0,
            showAudioPop:false,
        }
    },
    methods: {
        deleteFile(id){
                this.images.splice(id, 1)
                let dt = new DataTransfer();
                for (let i = 0; i < this.images.length; i++) {
                    dt.items.add(this.images[i])
                }
                document.querySelector('#images').files = dt.files;
            },
        previewImg(img){
                return URL.createObjectURL(img)
            },
        fileUpload(event) {
            /* if(this.realtime){[]
                this.$parent.isTyping()
            } */
                let inpImg = [...document.querySelector('#images').files];
                    this.images = inpImg;
            },
        recordButton($event) {
            /* if(this.realtime){
                this.$parent.isTyping()
            } */
            this.statusRecord = "record";
            this.device  = navigator.mediaDevices.getUserMedia({ audio: true });
            this.items = [];
            this.device.then((stream) => {
                this.recorder = new MediaRecorder(stream);
                this.recorder.ondataavailable = (e) => {
                    this.items.push(e.data);
                    if (this.recorder.state == "inactive") {
                        var blob = new Blob(this.items, { type: "audio/mpeg" });
                        this.audio = URL.createObjectURL(blob);
                        // this.audio.push(URL.createObjectURL(blob));


                        let container = new DataTransfer();
                        let audioFile = new File([blob], "audioTempFile"+ new Date().getTime()+".mpeg", { type: 'audio/mpeg', lastModified: new Date().getTime() });
                        container.items.add(audioFile);
                            this.recordValue = container;

}
                };
                this.recorder.start();
            });

            this.recordTimeS = 0;
            this.recordTimeM = 0;
            let myInterval = setInterval(() => {
                if(this.statusRecord == "stop") {
                    clearInterval(myInterval);
                    }
                this.recordTimeS = this.recordTimeS + 1;
                if(this.recordTimeS == 60) {
                    this.recordTimeS = 0;
                    this.recordTimeM = this.recordTimeM + 1;
                }
            }, 1000);

            setTimeout(() => {
                if(this.statusRecord == "record") {
                    this.statusRecord = "stop";
                    this.recorder.stop()
                }
            }, this.maxTimeRecord * 1000 * 60);
            this.showAudioPop = true;
        },
        stopButton($event) {
                this.statusRecord = "stop";
                this.recorder.stop()
        },
        sendRecord($event) {
            this.record.push(this.audio);
            this.recordTimeM = 0;
            this.recordTimeS = 0;
            this.showAudioPop = false;
            var boxFile = document.querySelector('.box-inp-rec');
            var inpFile = document.createElement("INPUT");
            inpFile.setAttribute("type", "file");
            inpFile.setAttribute("name", "images[]");
            inpFile.setAttribute("id","inp-rec");
            inpFile.style.visibility = "hidden";
            inpFile.style.position = "absolute";
            boxFile.appendChild(inpFile)
            inpFile.files =this.recordValue.files;
            this.itemsRealtime.push(inpFile.files[0])
        },
        removeRecord(id) {
            this.record.splice(id, 1)
            let boxInpts = [...document.querySelectorAll('.box-inp-rec #inp-rec')];
            boxInpts.splice(id, 1)
            let box = document.querySelector('.box-inp-rec');
            box.innerHTML = "";
            boxInpts.forEach(e => {
                box.appendChild(e);
            });
            this.itemsRealtime.splice(id, 1)
        },
        sendForm() {
            var boxMsg = document.querySelector(".box-msg");
            boxMsg.scrollTo(0,boxMsg.scrollHeight);
            this.msg = '';
            this.images = [];
            this.record = [];
            this.recordValue = '';
            this.recorder = '';
            this.device = '';
            this.items = [];
            this.itemsRealtime = [];
            this.audio = [];
            this.statusRecord = '';
            this.recordTimeS = 0;
            this.recordTimeM = 0;
            let box = document.querySelector('.box-inp-rec');
            box.innerHTML = "";
        },
        inpArbi($event) {
            var formControl =$event.target;
                        var valueBeforeChange = formControl.value;
                        var allowedValue = ' ';
                        allowedValue += "ياىآبپتثجچهخدذرزژسشصضطظعغفقکگلمنوحكةؤءئأإ"; //or any collection in any language you want
                        allowedValue += "0123456789"; // normal digits
                    allowedValue += "۰۱۲۳۴۵۶۷۸۹"; // arabic digits
                    allowedValue += "،.=+-)(*&%$#@!/_.|"; // allowed symbols
                    allowedValue += "\n";

                var valueAfterChange = '';
                for (var i = 0; i < valueBeforeChange.length; i++) {
                    var tmpChar = valueBeforeChange.charAt(i);
                    if (allowedValue.indexOf(tmpChar) > -1) valueAfterChange = valueAfterChange + tmpChar;
                }
                formControl.value = valueAfterChange;
                if (document.querySelector('#inp-op')) {
                    document.querySelector('#inp-op').focus();
                    formControl.focus();
                }
            },

    },

    mounted() {
  },
    template:` <x-template-attach></x-template-attach> `
});

</script>
@endpush
