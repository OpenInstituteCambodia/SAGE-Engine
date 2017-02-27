import { Injectable } from '@angular/core';
import { Device, NativeAudio } from 'ionic-native';

/*
  name: "xelaAudio"
  description: "Self Audio Introduction System, Used for children, literacy or disabled people to help navigate on using the application."
  author: ""
  developers: [
    "Socheat Sok (socheatsok78@gmail.com)",
    "Sinat Heum (heumsinatgic25@gmail.com)",
    "Sorya Phoeun (soryaphoeun08@gmail.com)"
  ]
  licenses: "GNU GPL"
*/

@Injectable()
export class xelaAudio {
  private _platform = Device.platform;

  public isFinished: boolean = true;
  private _unloadTimer: number = 0;
  private _playbackUUID: Array<any> = []; // Store Media Playback UID for Unloading when there is error during automatic unload once the playback finished
  constructor() {

  }

  get isFinishedPlaying() {
    return this.isFinished;
  }

  private setup_playbackUUID(options): void {
    if (this._playbackUUID.indexOf(options) == -1) {
      this._playbackUUID.push(options);
    }
    console.log("Media Playback UUID", this._playbackUUID);
  }

  public play(options: any): boolean {
    // Inspecting Platform for linking asset file
    this.setup_playbackUUID(options["u_id"]);
    if (this._platform != 'Android') {
      console.log("xelaController: xelaAudio: play() -> Platform Does Not Support");
      this.isFinished = true;
      return false;
    }
    this.isFinished = false;
    NativeAudio.preloadSimple(options["u_id"], options["path"]).then(
      (suc) => {
        console.log("xelaController: xelaAudio: play() -> NativeAudio.preloadSimple() -> Mediaplayer Init", suc);
        // Unload Playback once Finished
        NativeAudio.play(options["u_id"], (suc) => {
          console.log("xelaController: xelaAudio: play() -> NativeAudio.play() -> Playback Finished", suc);
          NativeAudio.unload(options["u_id"]).then(
            function(suc){
              console.log("xelaController: xelaAudio: play() -> NativeAudio.unload() Success -> " + options["u_id"], suc);
            },
            function(err){
              console.log("xelaController: xelaAudio: play() -> NativeAudio.unload() Something went wrong, Error -> " + options["u_id"], err);
            }
          );
          this.isFinished = true;
        });
      },
      (err) => {
        console.log("xelaController: xelaAudio: play() -> preloadSimple() -> Something went wrong, Error: ", err);
      }
    );
  } //play()

  public unload(): any {
    if (this._platform != 'Android') {
      console.log("xelaController: xelaAudio: unload() -> Platform Does Not Support");
      return false;
    }
    for (let i = 0; i < this._playbackUUID.length; i++) {
      console.log("xelaController: xelaAudio: unload() -> Unloading -> ", this._playbackUUID[i]);
        NativeAudio.unload(this._playbackUUID[i]).then((suc) => {
          console.log("xelaController: xelaAudio: unload() -> ", this._playbackUUID[i], suc);
        },(err) => {
          console.log("xelaController: xelaAudio: unload() -> ", err);
        });
    }
  } //unload()

}
