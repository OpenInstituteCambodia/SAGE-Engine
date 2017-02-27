![SAGE](https://www.dropbox.com/s/fhspe90nnvetrvm/sage-git.png?dl=1)

# SAGE Ionic2 Application Sample

### Getting Started

### [Design Guideline](https://www.dropbox.com/s/k0051opg7kujndz/Self-IVR%20Guideline.pdf?dl=1) | [Project Page](https://github.com/socheatsok78/SAGE-Ionic2-Application-Sample/projects) | [Interactive Preview](https://xd.adobe.com/view/1378509c-8914-4500-860b-ee6f70877f84/) | [Ionic Framework Documentations](http://ionicframework.com/docs/)

#### Setting up the development enviroment
```sh
  git clone https://github.com/socheatsok78/SAGE-Ionic2-Application-Sample.git
  cd SAGE-Ionic2-Application-Sample
  ionic state restore
  npm install
  bower install
```

### Documentations

#### Process Flow
- Process Flow PDF: [Download PDF](https://www.dropbox.com/s/s5swplog0pfstje/SAGE%20Diagram.pdf?dl=1)
- Self-IVR Applicaiton Flow: [Download PDF](https://www.dropbox.com/s/yv5pohy5ir1igkb/Self-IVR%20Flow.pdf?dl=1)

#### Prototype Guideline
- Adobe XD: [Preview](https://xd.adobe.com/view/1378509c-8914-4500-860b-ee6f70877f84/)
- PDF: [Download PDF](https://www.dropbox.com/s/sce6n1wbmetbbjw/Current%20Prototype%20Mobile%20App.pdf?dl=1)

##### Sources
- [Google Material Design](https://material.io/)
- [Barricade Style Guide](https://styleguide.barricade.io/styles.html)

<p align="center">
  <h3>Build with</h3>
  <a href="#"><img src="https://www.dropbox.com/s/fwfk6oku7p9plyi/ionic-logo.png?dl=1" /></a>
</p>


### Ionic Helper

#### Speed up Splashscreen
 - Update the following line in `config.xml`

 ```xml
 <preference name="SplashScreenDelay" value="1000" />
 ```

#### Generating resources (Icon/Splashscreen)
```sh
npm run gen:resources
```

#### Creating New Project
```sh
ionic start SAGE-Ionic2-Prototype --appname "SAGE Prototype" --id "org.self-ivr.prototype" --template "blank" --v2
```

#### Saving Working state
```sh
ionic state save
```
