<script setup lang="ts">
import type { ServiceItem } from '@/types'

interface ServiceSection {
  eyebrow: string
  title: string
  description: string
}

defineProps<{
  section: ServiceSection
  services: ServiceItem[]
}>()

const serviceLabel = (services: ServiceItem[], needle: string, fallback: string) =>
  services.find((service) => service.title.toLowerCase().includes(needle))?.title ?? fallback
</script>

<template>
  <section class="services-orbit overflow-hidden bg-black text-white">
    <div class="container-sahra relative z-10 py-14 md:py-20 lg:py-24">
      <div class="flex flex-col gap-12">
        <div class="service-eyebrow">
          <span aria-hidden="true" />
          {{ section.eyebrow || 'Our Services' }}
        </div>

        <div class="grid gap-8 lg:grid-cols-[506px_1fr] lg:gap-[130px]">
          <h2 class="max-w-[506px] text-[30px] font-semibold leading-[1.48] text-white md:text-[36px] lg:text-[40px] lg:leading-[1.5]">
            {{ section.title }}
          </h2>
          <p class="max-w-[612px] text-[15px] font-medium leading-[1.55] text-neutral-200 md:text-[18px]">
            {{ section.description }}
          </p>
        </div>
      </div>

      <div class="orbit-stage mt-[72px]" aria-label="Marketing services connected to brand growth">
        <div class="orbit-glow" aria-hidden="true" />
        <div class="orbit-line" aria-hidden="true" />
        <div class="orbit-circle orbit-circle--outer" aria-hidden="true" />
        <div class="orbit-circle orbit-circle--inner" aria-hidden="true" />

        <span class="orbit-endpoint orbit-endpoint--start" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--middle-a" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--middle-b" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--end" aria-hidden="true" />

        <strong class="orbit-axis orbit-axis--marketing">Marketing</strong>
        <strong class="orbit-axis orbit-axis--growth">Growth</strong>

        <span class="orbit-core">Clear Brand Presence</span>
        <span class="service-pill service-pill--social">
          {{ serviceLabel(services, 'social', 'Social Media support') }}
        </span>
        <span class="service-pill service-pill--branding">
          {{ serviceLabel(services, 'brand', 'Branding') }}
        </span>
        <span class="service-pill service-pill--content">
          {{ serviceLabel(services, 'content', 'Content Production') }}
        </span>
        <span class="service-pill service-pill--design">
          {{ serviceLabel(services, 'design', 'Marketing Design') }}
        </span>
      </div>
    </div>
  </section>
</template>

<style scoped>
.services-orbit {
  position: relative;
  min-height: 978px;
}

.service-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  width: fit-content;
  color: #bd933b;
  font-family: Idealist, serif;
  font-size: 24px;
  line-height: 1;
}

.service-eyebrow span {
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background: #bd933b;
  box-shadow: -2px -2px 12px rgb(189 147 59 / 50%), 2px 2px 12px rgb(189 147 59 / 50%);
}

.orbit-stage {
  position: relative;
  width: 1101px;
  height: 520px;
  margin-inline: auto;
}

.orbit-glow {
  position: absolute;
  z-index: -1;
  left: 50%;
  bottom: -264px;
  width: 1068px;
  height: 330px;
  transform: translateX(-50%);
  border-radius: 50%;
  background: rgb(189 147 59 / 20%);
  filter: blur(112px);
}

.orbit-line {
  position: absolute;
  top: 263px;
  left: 157px;
  width: 824px;
  border-top: 2px dotted #bd933b;
}

.orbit-circle {
  position: absolute;
  left: 50%;
  top: 50%;
  border: 2px dotted #bd933b;
  border-radius: 50%;
  transform: translate(-50%, -50%);
}

.orbit-circle--outer {
  width: 520px;
  height: 520px;
}

.orbit-circle--inner {
  width: 320px;
  height: 320px;
}

.orbit-axis {
  position: absolute;
  top: 245px;
  font-size: 24px;
  line-height: 36px;
  color: white;
}

.orbit-axis--marketing { left: 0; }
.orbit-axis--growth { right: 0; }

.orbit-endpoint {
  position: absolute;
  top: 257px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #bd933b;
  box-shadow: 0 0 8px rgb(189 147 59 / 55%);
}

.orbit-endpoint--start { left: 157px; }
.orbit-endpoint--middle-a { left: 404px; width: 10px; height: 10px; }
.orbit-endpoint--middle-b { left: 725px; width: 10px; height: 10px; }
.orbit-endpoint--end { left: 971px; }

.service-pill,
.orbit-core {
  position: absolute;
  z-index: 2;
  white-space: nowrap;
}

.service-pill {
  padding: 8px 16px;
  border-radius: 1000px;
  background: linear-gradient(rgb(255 255 255 / 20%), rgb(255 255 255 / 20%)),
    rgb(35 31 32 / 50%);
  font-size: 18px;
  font-weight: 500;
  line-height: 27px;
  color: white;
}

.service-pill--social { left: 345px; top: 98px; }
.service-pill--branding { left: 647px; top: 176px; }
.service-pill--content { left: 336px; top: 299px; }
.service-pill--design { left: 638px; top: 321px; }

.orbit-core {
  left: 490px;
  top: 245px;
  padding: 4px 8px;
  border-radius: 4px;
  background: linear-gradient(150deg, #bd933b 20%, #fff 145%);
  color: #231f20;
  font-family: Idealist, serif;
  font-size: 18px;
  line-height: 20px;
}

@media (max-width: 1023px) {
  .services-orbit {
    min-height: auto;
  }

  .orbit-stage {
    width: 100%;
    height: auto;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    padding-block: 72px 24px;
  }

  .orbit-circle--outer {
    width: min(78vw, 430px);
    height: min(78vw, 430px);
  }

  .orbit-circle--inner {
    width: min(48vw, 270px);
    height: min(48vw, 270px);
  }

  .orbit-line {
    left: 8%;
    right: 8%;
    top: 50%;
    width: auto;
  }

  .orbit-axis,
  .orbit-endpoint,
  .orbit-core {
    display: none;
  }

  .service-pill {
    position: relative;
    inset: auto;
    display: flex;
    min-height: 48px;
    align-items: center;
    justify-content: center;
    white-space: normal;
    text-align: center;
    font-size: 14px;
    line-height: 20px;
  }
}
</style>
