import { Injectable } from '@angular/core';
import { Platform, AlertController } from 'ionic-angular';

@Injectable()
export class xelaToolbar {

  constructor( private alert: AlertController, private platform: Platform ){}

  public exit(): void {
    console.log("xelaController: xelaToolbar: exit(): Active");
    let alert = this.alert.create({
      title: 'Confirm',
      message: 'Do you want to exit?',
      buttons: [
        {
          text: "No",
          role: 'cancel'
        },
        {
          text: "Yes",
          handler: () => {
            console.log("xelaController: xelaToolbar: exit(): Exit Application!");
            this.platform.exitApp();
          }
        },
      ]
    });
    alert.present();
  }
}
