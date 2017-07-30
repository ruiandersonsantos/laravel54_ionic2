import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import {Http} from "@angular/http";
import 'rxjs/add/operator/toPromise';
import {JwtClient} from "../../providers/jwt-client";



/**
 * Generated class for the LoginPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */
@IonicPage()
@Component({
  selector: 'page-Login',
  templateUrl: 'Login.html',
})
export class LoginPage {

  email:string;
  password:string;

  constructor(
      public navCtrl: NavController,
      public navParams: NavParams,
      public jwtClient:JwtClient) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad LoginPage');
  }

  login(){
    this.jwtClient.acessToken({email:this.email, password: this.password})
        .then((token) => {
            console.log(token);
        })
  }

}
