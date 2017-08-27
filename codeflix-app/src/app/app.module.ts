import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';

import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';
import { ListPage } from '../pages/list/list';
import {LoginPage} from "../pages/login/login";
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import {Http, HttpModule, XHRBackend} from "@angular/http";
import {JwtClient} from "../providers/jwt-client";
import {IonicStorageModule, Storage} from "@ionic/storage";
import {AuthConfig, AuthHttp, JwtHelper} from "angular2-jwt";
import {Auth} from "../providers/auth";
import {Env} from "../models/env";
import {DefaultXHRBackend} from "../providers/default-xhr-backend";
import {Redirector} from "../providers/redirector";
import {Facebook} from "@ionic-native/facebook";

declare var ENV: Env;

@NgModule({
  declarations: [
    MyApp,
    HomePage,
    ListPage,
    LoginPage
  ],
  imports: [
    HttpModule,
    BrowserModule,
    IonicModule.forRoot(MyApp,{},{
      links:[
        {component: LoginPage, name: 'LoginPage',segment: 'login'},
        {component: HomePage, name: 'HomePage',segment: 'home'}
      ]
    }),
    IonicStorageModule.forRoot({
      driverOrder: ['localstorage']
    })
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    ListPage,
    LoginPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    JwtClient,
    JwtHelper,
    Auth,
    Redirector,
    Facebook,
    {provide: ErrorHandler, useClass: IonicErrorHandler},
    {
      provide: AuthHttp,
      deps: [Http, Storage],
      useFactory(http,storage){
          let authConfig = new AuthConfig({
              headerPrefix: 'Bearer',
              noJwtError: true,
              noClientCheck: true,
              tokenGetter: (()=> storage.get(ENV.TOKEN_NAME))
          });

          return new AuthHttp(authConfig, http);
      }
    },
    {provide: XHRBackend, useClass: DefaultXHRBackend}
  ]
})
export class AppModule {}
