<template>
  <div class="card">
    <el-card :body-style="{ padding: '0px' }">
      <img src="/images/pexels-pixabay-259588.jpg" class="card__image">
      <div class="card__description">
        <span class="card__description__price">R 3 259 999 </span>
        <span class="card__description__name">Farm House</span>
        <div class="card__description__location">
          <img class="card__description__location__icon" 
            src="/icons/location.svg" 
            alt="location droppoint"/>
          <span class="card__description__location__text">Centurion</span>
        </div>
        <div class="card__description__stats">
          <div class="card__description__stats__container">
            <span class="card__description__stats__container__number">2</span>
            <img class="card__description__stats__container__icon" 
              src="/icons/bed.svg" 
              alt="location droppoint"/>
          </div>
          <div class="card__description__stats__container">
            <span class="card__description__stats__container__number">2</span>
            <img class="card__description__stats__container__icon" 
              src="/icons/bath.svg" 
              alt="location droppoint"/>
          </div>
        </div>
      </div>
    </el-card>
    </div>
</template>

<script>
</script>

<style<style lang="scss" scoped>

  .card {
    width: 20rem;
    &__image {
      width: 100%
    }
    &__description {
      display: flex;
      flex-flow: column nowrap;
      padding: 1rem;
      font-weight: 500;
      &__location {
        display: flex;
        flex-flow: row nowrap;
        align-items: center;
        padding: .5rem 0;
        &__icon {
          height: 1.25rem;
          width: 1.25rem;
        }
        &__text {
          color: #989898;
          font-size: 1rem;
        }
      }
      &__stats {
        display: flex;
        flex-flow: row nowrap;
        align-items: center;
        &__container{
          display: flex;
          flex-flow: row nowrap;
          align-items: center;
          padding: 0 1rem 0 0;
          &__number {
            font-size: 1.5rem;
            padding:0 .5rem 0 0;
          }
          &__icon {
            height: 2rem;
            width:2rem;
          }
        }
      }

    }
  }
</style>
