import { Component } from '@angular/core';
import {IonicPage, NavController, NavParams, MenuController, ToastController} from 'ionic-angular';
import 'rxjs/add/operator/toPromise';
import {Auth} from "../../providers/auth";
import {HomePage} from "../home/home";


@IonicPage()
@Component({
  selector: 'page-Login',
  templateUrl: 'Login.html',
})
export class LoginPage {

  user = {
    email: 'admin@user.com',
    password:'secret'
  }


  constructor(
      public navCtrl: NavController,
      public menuCrt: MenuController,
      public toastCrt: ToastController,
      public navParams: NavParams,
      public auth:Auth) {

      this.menuCrt.enable(false);
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad LoginPage');
  }

  login(){
    this.auth.login(this.user)
        .then(()=>{
            this.afterLogin();
        })
        .catch(()=>{
            let toast = this.toastCrt.create({
                message: 'Email e/ou senhas inválidos.',
                duration: 3000,
                position: 'top',
                cssClass: 'toast-login-error'
            });

            toast.present();
        });

  }

  loginFacebook(){
    this.auth.loginFacebook();
  }


  afterLogin(){
      this.menuCrt.enable(true);
      this.navCtrl.push(HomePage);

  }

  irParaHome(){
      this.navCtrl.push(HomePage);
  }

}
