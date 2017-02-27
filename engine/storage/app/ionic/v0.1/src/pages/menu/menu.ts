import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { xelaController } from '../../app/xelaController';
import { xelaRoute } from '../../app/xelaModule/xelaRoute';
import { xelaToolbar } from '../../app/xelaModule/xelaToolbar';
import { QuestionPage } from '../question/question';


@Component({
  selector: 'page-menu',
  templateUrl: 'menu.html',
  providers: [ xelaController, xelaRoute, xelaToolbar ]
})
export class MenuPage {
  public menuID; // 1 is for root menu

  constructor(
    public navCtrl: NavController,
    public navParams: NavParams,
    private _xela: xelaController,
    private _route: xelaRoute,
    private _toolbar: xelaToolbar) {
      console.log(this.navParams.get("_id"));
      if (typeof this.navParams.get("_id") == 'undefined') {
        this.menuID = 0;
      }else {
        this.menuID = this.navParams.get("_id");
      }

  }

  public question(_id) {
    this._route.go(
      QuestionPage, {
        _id: _id
      }
    );
  }
  public menu(_id) {
    this._route.go(
      MenuPage, {
        _id: _id
      }
    );
  }

  public exit() {
    this._toolbar.exit();
  }

}
