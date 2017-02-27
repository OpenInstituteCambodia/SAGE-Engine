import { Component } from '@angular/core';
import { Platform } from 'ionic-angular';
import { StatusBar, Splashscreen } from 'ionic-native';
import { MenuPage } from '../pages/menu/menu';

/*
  NOTHING TO EDIT HERE !!!
  GO AWAY!!!
*/

@Component({
  templateUrl: 'app.html'
})
export class MyApp  {
  public rootPage: any  = MenuPage;

  constructor(platform: Platform) {
    platform.ready().then(() => {
      StatusBar.styleDefault();
      Splashscreen.hide();
    });
  }

}
