<div class="form_content " :id="id">
    <input type="text" name="" id="inp-op">
    <div class="contact_content">
        <!-- attached file -->
        <div class="form-cons">
            <label for="">الملفات</label>
            <div class="d-flex flex-column gap-2 ">
                    <div class="attach-file">
                            <input type="file" @change="fileUpload($event)" name="images[]" id="images" class="file-inp"
                                multiple />
                                <span>سحب وإفلات أو <div class="main-color d-inline-block">تصفح</div> </span>
                    </div>
                <ul class="show_upload_file list-unstyled m-0">
                    <li v-for='(img,i) in images' :key='i'>
                        <div class="img_holder">
                            <img v-if="img.type.split('/')[0] == 'image'" :src="previewImg(img)" alt="image preview">
                            <h3 v-else class="text-primary text-center mb-0"><i class="fa-solid fa-file"></i></h3>
                        </div>
                        <div class="text_info">
                            <p class="mb-2">@{{img.name}}</p>
                            <small>KB @{{Math.floor(img.size / 1000)}}</small>
                        </div>
                        <button @click.prevent='deleteFile(i)' class="delete_file">x</button>
                    </li>
                </ul>
            </div>
            <small>أرفق ملفات لها علاقة بالاستشارة ان وجد</small>
        </div>

        <!-- attached voice -->
        <div class="form-cons">
            <label for="">تسجيل صوتي</label>
            <div class="d-flex flex-column gap-2 ">
                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="add_voice ">
                <i class="fa-solid fa-microphone"></i>
                </button>
                <div class="show-record d-flex align-items-center gap-2" v-for='(rec,i) in record' :key='i'>
                    <div class="btn btn-danger" @click="removeRecord(i,$event)"> <i class="fas fa-trash-can"></i></div>
                    <audio :src="rec" controls>
                        <source :src="rec" type="audio/mpeg">
                    </audio>
                </div>
                <!-- modal voice -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header p-0">
                                <h5 class="modal-title alt-modal-title" id="exampleModalLabel">
                                    تسجيل صوتي
                                </h5>
                                <button type="button" class="btn-close ms-0 me-auto record_close_btn"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body ">
                                <div
                                    class="voice_content d-flex flex-column align-items-center justify-content-center py-2">
                                    <button type='button'
                                        class="alt_btn-primary start_record_btn btn btn-primary rounded-circle"
                                        @click="recordButton($event)" id="record"
                                        :class="[statusRecord == 'record' ? 'd-none' :'',statusRecord == 'stop' ? 'd-block' :'']">
                                        <i class="fa-solid fa-microphone"></i>
                                    </button>

                                    <div class="stop_record_holder mb-2"
                                        :class="[statusRecord == 'record' ? 'd-block' :'',statusRecord == 'stop' ? 'd-none' :'']">
                                        <button type='button' class="stop_record_btn btn btn-outline-danger rounded-circle"
                                            id="stop" @click="stopButton($event)">
                                            <i class="fa-regular fa-square"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 align-items-center justify-content-center">
                                    <span class="d-block">
                                        @{{recordTimeM}}:@{{recordTimeS}}
                                    </span>
                                    <span class="d-block">
                                        /
                                    </span>
                                    <span class="d-block">
                                        @{{maxTimeRecord}}:0
                                    </span>
                                </div>
                                <div id="bars-voice" class="mx-auto"
                                    :class="[statusRecord == 'record' ? 'd-flex' :'d-none',statusRecord == 'stop' ? 'd-none' :'']">
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                </div>
                                <div class="audio_holder " v-if="showAudioPop"
                                    :class="[statusRecord == 'record' ? 'd-none' :'',statusRecord == 'stop' ? 'd-block' :'']">

                                    <audio id="player" :src="audio" class="w-100 mt-3" controls></audio>
                                </div>
                                <!-- <input type="file" name="images[]" style="visibility: hidden;     position: absolute;
        "
                                :id="'file' + id" multiple capture> -->
                                <div class="box-inp-rec">
                                    <!-- <input type="file" id="inp-file" name="images[]" style="visibility: hidden; position: absolute;"multiple > -->
                                </div>
                            </div>
                            <div
                                class="modal-footer border-top-0 d-flex align-items-center justify-content-center pt-3 pb-4">
                                <button type="button" class="send-record btn btn-success w-100 rounded-pill alt_btn-success"
                                    :class="[statusRecord == 'stop' ? 'show' :'']" data-bs-dismiss="modal"
                                    @click="sendRecord($event)">
                                    <i class="fa-regular fa-paper-plane"></i>
                                    إرفاق التسجيل الصوتي
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="textArea_holder" v-if="show">

                    <textarea v-if='realtime' :name="name" id="" class="" :placeholder="place?place:'أرسل رسالتك'"
                        @input="inpArbi($event);" v-model.lazy='msg' @keydown="$parent.isTyping()"></textarea>
                    <textarea v-else :name="name" id="" class="" :placeholder="place?place:'أرسل رسالتك'"
                        @input="inpArbi($event)" v-model.lazy='msg'></textarea>
                </div>
                <div class="send_btn_holder d-flex align-items-center justify-content-center" v-if="show">
                    <button :disabled='images.length==0 && items.length==0 && msg==""'
                        @click="$parent.storeMessage();sendForm()" class="send_btn btn" v-if='realtime'>
                        إرسال
                        <i class="fa-regular fa-paper-plane"></i>
                    </button>
                    <button class="send_btn btn" v-else>
                        إرسال
                        <i class="fa-regular fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
